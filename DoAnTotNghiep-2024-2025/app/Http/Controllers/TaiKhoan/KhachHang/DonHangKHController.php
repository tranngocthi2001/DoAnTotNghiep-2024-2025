<?php
namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Http\Controllers\Controller;


use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\ChiTietDonHang;
use App\Models\DanhMuc;
use App\Models\KhachHang;
use App\Models\ThanhToan;
use App\Models\YeuCauDoiHang;
use Illuminate\Http\Request;

class DonHangKHController extends Controller
{

    // Hiển thị đơn hàng cho khách hàng và chọn phương thức thanh toán
    public function dondathang()
    {
        $danhmucs = DanhMuc::all();

        // Lấy giỏ hàng của khách hàng hiện tại
        $giohang = GioHang::with('chiTietGioHangs.sanPhams', 'khachHang')
            ->where('khachhang_id', auth()->user()->id)
            ->first();
        //dd($giohang);
        // Kiểm tra xem giỏ hàng có sản phẩm hay không
        if (!$giohang || $giohang->tongTien <= 0 || !$giohang->chiTietGioHangs || $giohang->chiTietGioHangs->isEmpty()) {
            return redirect()->route('giohang.index')->withErrors('Giỏ hàng của bạn trống hoặc không hợp lệ.');
        }

        // Truyền thông tin giỏ hàng cho view, bao gồm chi tiết giỏ hàng
        return view('taikhoans.khachhangs.dondathang', [
            'giohang' => $giohang,
            'chiTietGioHangs' => $giohang->chiTietGioHangs
        ], compact('danhmucs'));
    }
    public function index()
    {
        $danhmucs = DanhMuc::all();

         // Lấy danh sách đơn hàng của khách hàng hiện tại
        $donhangs = DonHang::where('khachhang_id', auth()->user()->id)
        ->where(function ($query) {
            $query->where('trangThai', '=', 'đã giao cho đơn vị vận chuyển')
                  ->orWhere('trangThai', '=', 'đang xử lý')
                  ->orWhere('trangThai', '=', 'COD')
                  ->orWhere('trangThai', '=', 'Đã thanh toán');
        })
        ->orderBy('ngayDatHang', 'desc')
        ->get();

        $donhangsHoanThanh = DonHang::where('khachhang_id', auth()->user()->id)
        ->where('trangThai', '=', 'đã hoàn thành')
        ->orderBy('ngayDatHang', 'desc')->get();

        $donhangsDoi = DonHang::where('khachhang_id', auth()->user()->id)
        ->where('trangThai', '=', 'Đổi hàng')
        ->orderBy('ngayDatHang', 'desc')->get();

        $donhangsHuy = DonHang::where('khachhang_id', auth()->user()->id)
        ->where('trangThai', '=', 'Đã hủy')
        ->orwhere('trangThai', '=', 'Chờ xác nhận hủy')
        ->orderBy('ngayDatHang', 'desc')->get();

        $donhangsChothanhtoan = DonHang::where('khachhang_id', auth()->user()->id)
        ->where('trangThai', '=', 'Chờ thanh toán')
        ->orderBy('ngayDatHang', 'desc')->get();
        //dd($donhangsChothanhtoan);
        return view('taikhoans.khachhangs.donhang',
         compact('donhangs','donhangsHoanThanh','donhangsHuy',
         'donhangsDoi','danhmucs', 'donhangsChothanhtoan'));
    }

    public function donHangCreate(Request $request)
    {
        $danhmucs=DanhMuc::all();

        // Lấy giỏ hàng của khách hàng hiện tại
            $giohang = GioHang::with('chiTietGioHangs.sanPhams', 'khachHang')
            ->where('khachhang_id', auth()->user()->id)
            ->first();
//dd($giohang);
        // Kiểm tra giỏ hàng hợp lệ
        if (!$giohang || $giohang->tongTien <= 0 || !$giohang->chiTietGioHangs || $giohang->chiTietGioHangs->isEmpty()) {
            return redirect()->route('giohang.index')->withErrors('Giỏ hàng của bạn trống hoặc không hợp lệ.');
        }
        $khachhang = $giohang->khachHang;
        //dd($request->all());
        // Tạo đơn hàng
        $donHang = DonHang::create([
            'khachhang_id' => $giohang->khachhang_id,
            'tongTien' => $giohang->tongTien,
            'trangThai' => 'Chờ thanh toán',
            'diaChiGiaoHang' => $request->input('diaChi', $giohang->khachHang->diaChi),
            'sdt' => $request->input('sdt', $giohang->khachHang->sdt),
            'ngayDatHang' => now(),
            'phuongThucThanhToan' => $request->input('phuongThucThanhToan'),
            'tenKhachHang'=>  $request->input('hoTen', $giohang->khachHang->hoTen),
            'maVanChuyen'=>null,
        ]);
            //dd($donHang);
            if (!$giohang->chiTietGioHangs || $giohang->chiTietGioHangs->isEmpty()) {
                return redirect()->route('giohang.index')->withErrors('Giỏ hàng trống, không thể tạo đơn hàng.');
            }
        // Lưu chi tiết đơn hàng và bảng liên kết
        foreach ($giohang->chiTietGioHangs  as $chitietgiohang) {
            // Lưu chi tiết đơn hàng
            $chiTietDonHang = ChiTietDonHang::create([
                'donhang_id' => $donHang->id,
                'soLuong' => $chitietgiohang->soLuong,
                'gia' => $chitietgiohang->gia,
            ]);
            // Chuyển sản phẩm từ bảng liên kết `sanpham_has_chitietgiohang` sang `sanpham_has_chitietdonhang`
            foreach ($chitietgiohang->sanphams as $sanpham) {
                $chiTietDonHang->sanphams()->attach($sanpham->id, [
                    'soLuong' => $sanpham->pivot->soLuong,
                ]);
                 // Trừ số lượng sản phẩm trong kho
                $sanpham->soLuong -= $sanpham->pivot->soLuong; // Giảm số lượng
                $sanpham->save(); // Lưu lại sản phẩm sau khi trừ
            }
                // Xóa sản phẩm trong giỏ hàng
                $chitietgiohang->sanphams()->detach();
                $chitietgiohang->delete();

        }//dd($chiTietDonHang);
        // Xóa giỏ hàng
            $giohang->tongTien = 0;
            $giohang->tongSoLuong = 0;
            $giohang->save();

    // Kiểm tra phương thức thanh toán
        if ($request->input('phuongThucThanhToan') == 'Thanh toán qua cổng thanh toán VnPay') {
            // Chuyển hướng đến trang thanh toán
            return view('taikhoans/khachhangs.vnpaycreate', compact('donHang','danhmucs'));
            //return redirect()->route('vnpay.create', ['donhang_id' => $donHang->id]);
        }else
        {
            $donHang->trangThai='COD';
            $donHang->save();
            return redirect()->route('khachhang.donhang.index', compact('danhmucs'))->with('success', 'Đơn hàng của bạn đã được tạo thành công!');
        }
    }

    public function show($id)
    {
            // Lấy thông tin đơn hàng
        $donhang = DonHang::with('chiTietDonHangs.sanphams')->findOrFail($id);
//dd($donhang);
        // Lấy giỏ hàng của khách hàng hiện tại để lấy họ tên khách hàng
        $giohang = GioHang::with('chiTietGioHangs.sanPhams', 'khachHang')
        ->where('khachhang_id', auth()->user()->id)
        ->first();

        $yeuCauDoiHang = null;
        foreach ($donhang->chiTietDonHangs as $chiTietDonHang) {
            //dd($donhang);
            foreach ($chiTietDonHang->chiTietPhieuXuats as $chiTietPhieuXuat) {
                //dd($chiTietDonHang);
                if ($chiTietPhieuXuat->yeucaudoihang_id) {
                    //dd($chiTietPhieuXuat);
                    $yeuCauDoiHang = $chiTietPhieuXuat->yeucaudoihang;  // Lấy yêu cầu đổi hàng từ mối quan hệ
                    //break 2;  // Dừng vòng lặp khi đã tìm thấy yêu cầu đổi hàng
                }
            }//dd($yeuCauDoiHang);
            $danhmucs=DanhMuc::all();
}            // Trả về view với thông tin đơn hàng và tên khách hàng
        return view('taikhoans.khachhangs.chitietdonhang', compact('donhang','yeuCauDoiHang','danhmucs'));
    }


    public function huyDonHang($id)
    {
         // Tìm đơn hàng theo ID, khách hàng, và trạng thái
    $donhang = DonHang::where('id', $id)
        ->where('khachhang_id', auth()->user()->id)
        ->where(function ($query) {
            $query->where('trangThai', 'COD')
                ->orWhere('trangThai', 'Đã thanh toán');
        })->first();
//dd($donhang);
        if (!$donhang) {
            return redirect()->back()->with('error', 'Đơn hàng không thể hủy.');
        }

        // Cập nhật trạng thái đơn hàng thành "Đã hủy"
        $donhang->update(['trangThai' => 'Chờ xác nhận hủy']);

        return redirect()->route('khachhang.donhang.index')->with('success', 'Đơn hàng đã được hủy.');
    }


    public function update(Request $request, $id)
    {
        // Lấy danh sách danh mục (nếu cần hiển thị lại view)
        $danhmucs = DanhMuc::all();

        // Tìm đơn hàng theo ID
        $donHang = DonHang::findOrFail($id);

        //dd($donHang);
        // Cập nhật thông tin đơn hàng
        $donHang->update([
            'trangThai' => 'Chờ thanh toán',
            'diaChiGiaoHang' => $request->input('diaChi', $donHang->diaChiGiaoHang),
            'sdt' => $request->input('sdt', $donHang->sdt),
            'phuongThucThanhToan' => $request->input('phuongThucThanhToan', $donHang->phuongThucThanhToan),
            'tenKhachHang' => $request->input('hoTen', $donHang->tenKhachHang),
        ]);
//dd($donHang);
        // Nếu trạng thái là "Đã hủy", hoàn lại số lượng sản phẩm trong kho
        if ($request->input('trangThai') == 'Đã hủy') {
            foreach ($donHang->chiTietDonHangs as $chiTietDonHang) {
                foreach ($chiTietDonHang->sanphams as $sanpham) {
                    $sanpham->soLuong += $sanpham->pivot->soLuong; // Hoàn lại số lượng
                    $sanpham->save(); // Lưu lại thông tin sản phẩm
                }
            }
        }

        if ($request->input('phuongThucThanhToan') == 'Thanh toán qua cổng thanh toán VnPay') {
            // Chuyển hướng đến trang thanh toán
            return view('taikhoans/khachhangs.vnpaycreate', compact('donHang','danhmucs'));
            //return redirect()->route('vnpay.create', ['donhang_id' => $donHang->id]);
        }else
        {
            $donHang->trangThai='COD';
            $donHang->save();
            $thanhtoan= new ThanhToan();
            $thanhtoan->donhang_id=$donHang->id;
            $thanhtoan->phuongThuc = 'Thanh toán khi nhận hàng (COD)';
            $thanhtoan->trangThaiGiaoDich='Chờ thanh toán';
            $thanhtoan->soTien= $donHang->tongTien;
            $thanhtoan->maGiaoDichVnpay='null';

            $thanhtoan->save();
//dd($thanhtoan);
            return redirect()->route('khachhang.donhang.index', compact('danhmucs'))->with('success', 'Đơn hàng của bạn đã được tạo thành công!');
        }
    }

}



