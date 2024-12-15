<?php
namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Http\Controllers\Controller;


use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\ChiTietDonHang;
use App\Models\DanhMuc;
use App\Models\KhachHang;
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
                  ->orWhere('trangThai', '=', 'chưa xác nhận');
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
        ->where('trangThai', '=', 'đã hủy')
        ->orderBy('ngayDatHang', 'desc')->get();
        //dd($donhangs);
        return view('taikhoans.khachhangs.donhang',
         compact('donhangs','donhangsHoanThanh','donhangsHuy','donhangsDoi','danhmucs'));
    }

    public function donHangCreate(Request $request)
    {
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



        // Tạo đơn hàng
        $donHang = DonHang::create([
            'khachhang_id' => $giohang->khachhang_id,
            'tongTien' => $giohang->tongTien,
            'trangThai' => 'Chưa xác nhận',
            'diaChiGiaoHang' => $request->input('diaChi', $giohang->khachHang->diaChi),
            'sdt' => $request->input('sdt', $giohang->khachHang->sdt),
            'ngayDatHang' => now(),
            'phuongThucThanhToan' => $request->input('phuongThucThanhToan'),
            'tenKhachHang'=>  $request->input('hoTen', $giohang->khachHang->hoTen),
            'maVanChuyen'=>null,

        ]);
        // Kiểm tra phương thức thanh toán
        if ($request->input('phuongThucThanhToan') == 'Thanh toán qua ví điện tử Momo') {
            // Chuyển hướng đến trang thanh toán Momo
            return redirect()->route('momo.payment', ['donhangId' => $donHang->id]);
        }
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
        }

        // Xóa giỏ hàng
        $giohang->tongTien = 0;
        $giohang->tongSoLuong = 0;
        $giohang->save();

        return redirect()->route('khachhang.donhang.index')->with('success', 'Đơn hàng của bạn đã được tạo thành công!');
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
        //$khachhang=$giohang->khachHang;

        // Truy vấn yêu cầu đổi hàng bằng donhang_id
        // $yeuCauDoiHang = YeuCauDoiHang::with('chitietdoihangs')
        // ->where('id', $donhang->id)->first();
        // if (!$yeuCauDoiHang) {
        //     return redirect()->route('taikhoans.khachhangs.yeucaudoihang.show')
        //     ->with('error', 'Yêu cầu đổi hàng không tồn tại.');
        // }
        $yeuCauDoiHang = null;
        foreach ($donhang->chiTietDonHangs as $chiTietDonHang) {
            //dd($donHang);
            foreach ($chiTietDonHang->chiTietPhieuXuats as $chiTietPhieuXuat) {
                //dd($chiTietDonHang);
                if ($chiTietPhieuXuat->yeucaudoihang_id) {
                    //dd($chiTietPhieuXuat);
                    $yeuCauDoiHang = $chiTietPhieuXuat->yeucaudoihang;  // Lấy yêu cầu đổi hàng từ mối quan hệ
                    //break 2;  // Dừng vòng lặp khi đã tìm thấy yêu cầu đổi hàng
                }
            }//dd($yeuCauDoiHang);
}            // Trả về view với thông tin đơn hàng và tên khách hàng
        return view('taikhoans.khachhangs.chitietdonhang', compact('donhang','yeuCauDoiHang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'trangThai' => 'required',
            'maVanChuyen' => 'nullable|string|max:50',

        ]);

       // Tìm đơn hàng theo ID
        $donhang = DonHang::findOrFail($id);


        // Cập nhật trạng thái đơn hàng và lưu nhân viên thực hiện
        $donhang->update([
            'trangThai' => $request->input('trangThai'),
        ]);


    }

    public function huyDonHang($id)
    {
        // Tìm đơn hàng
        $donhang = DonHang::where('id', $id)
            ->where('khachhang_id', auth()->user()->id)
            ->where('trangThai', 'Chưa xác nhận') // Chỉ hủy đơn hàng chưa xác nhận
            ->first();

        if (!$donhang) {
            return redirect()->back()->with('error', 'Đơn hàng không thể hủy.');
        }

        // Cập nhật trạng thái đơn hàng thành "Đã hủy"
        $donhang->update(['trangThai' => 'đã hủy']);

        return redirect()->route('taikhoans.khachhangs.donhang')->with('success', 'Đơn hàng đã được hủy.');
    }

}



