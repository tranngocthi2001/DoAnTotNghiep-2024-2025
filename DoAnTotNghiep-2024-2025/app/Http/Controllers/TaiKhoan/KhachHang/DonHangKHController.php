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
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;
use App\Models\SanPham;
use App\Mail\ProductLowStockNotification;
use App\Models\ChiTietPhieuXuat;
use App\Models\PhieuXuatHang;
use Illuminate\Http\Resources\MergeValue;

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
        $khachhang= auth()->user();
        //dd($khachhang);
        // Truyền thông tin giỏ hàng cho view, bao gồm chi tiết giỏ hàng
        return view('taikhoans.khachhangs.dondathang', [
            'giohang' => $giohang,
            'chiTietGioHangs' => $giohang->chiTietGioHangs,
            'khachHang'=>$khachhang
        ], compact('danhmucs'));
    }

    public function index()
    {
        $danhmucs = DanhMuc::all();
//dd(auth()->user()->id);
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
//dd($donhangs);
        $donhangsHoanThanh = DonHang::where('khachhang_id', auth()->user()->id)
        ->where('trangThai', '=', 'đã hoàn thành')

        ->orderBy('ngayDatHang', 'desc')->get();
        $donhangsDoi = DonHang::where('khachhang_id', auth()->user()->id)
        ->where('trangThai', '=', 'Đổi hàng')
        ->orderBy('ngayDatHang', 'desc')->get();
//dd(auth()->user()->id);
//dd($donhangsHoanThanh);
        $donHangsCuDaDoi = DonHang::where('khachhang_id', auth()->user()->id)
            ->where(function($query) {
                $query->where('trangThai', '=', 'Đã chấp nhận đổi')
                    ->orWhere('trangThai', '=', 'Từ chối đổi hàng');
            })
            ->orderBy('id', 'desc')
            ->get();
            // dump(auth()->user());
            // dd($donHangsCuDaDoi);

        $donHangsDaDoi = DonHang::where('khachhang_id', auth()->user()->id)
            ->where('trangThai', '=', 'Đang chờ nhận lại hàng')
            ->orderBy('id', 'desc')
            ->get();
        $donhangsHuy = DonHang::where('khachhang_id', auth()->user()->id)
        ->where(function ($query) {
            $query->where('trangThai', '=', 'Đã hủy')
                ->orWhere('trangThai', '=', 'Chờ xác nhận hủy');
        })
        ->orderBy('ngayDatHang', 'desc')
        ->get();
//dd($donhangsHuy);
        $donhangsChothanhtoan = DonHang::where('khachhang_id', auth()->user()->id)
        ->where('trangThai', '=', 'Chờ thanh toán')
        ->orderBy('ngayDatHang', 'desc')->get();
        //dd($donhangsChothanhtoan);
        return view('taikhoans.khachhangs.donhang',
         compact('donhangs','donhangsHoanThanh','donhangsHuy',
         'donhangsDoi','danhmucs', 'donhangsChothanhtoan','donHangsDaDoi','donHangsCuDaDoi'));
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
            //gửi mail khi sản phẩm dưới 10
            $sanPhams = SanPham::all();
            foreach ($sanPhams as $sanPham) {
                if ($sanPham->soLuong < 1) {
                    $adminEmail = 'thi.03092001@gmail.com';
                    Mail::to($adminEmail)->send(new ProductLowStockNotification($sanPham));
                }
            }

    // Kiểm tra phương thức thanh toán
        if ($request->input('phuongThucThanhToan') == 'Thanh toán qua cổng thanh toán VnPay') {
            // Chuyển hướng đến trang thanh toán
            return view('taikhoans/khachhangs.vnpaycreate', compact('donHang','danhmucs'));
        }else
        {
            $donHang->trangThai='COD';
            $donHang->save();
            $payment = new ThanhToan();
                $payment->donhang_id = $donHang->id;
                $payment->phuongThuc = 'Thanh toán khi nhận hàng (COD)';
                $payment->soTien = $donHang->tongTien;
                $payment->trangThaiGiaoDich = 'COD'; // Bạn có thể sử dụng trạng thái 'Chờ thanh toán' hoặc một trạng thái nào đó phù hợp
                $payment->ngayGiaoDich = now();
                //$payment->maGiaoDichVnpay=$donHang->id;
                $payment->save(); // Lưu thông tin thanh toán vào bảng
            Mail::to(auth()->user()->email)->send(new OrderPlaced($donHang));
            return redirect()->route('khachhang.donhang.index', compact('danhmucs'))->with('dathangthanhcong', 'Đơn hàng của bạn đã được tạo thành công!');
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

        $yeuCauDoiHangID=null;
        $phieuxuathangs=PhieuXuatHang::where('donhang_id', $donhang->id)->first();
        if($phieuxuathangs){
            $chiTietPhieuXuats=ChiTietPhieuXuat::where('phieuxuathang_id', $phieuxuathangs->id)->get();
            foreach($chiTietPhieuXuats as $chiTietPhieuXuat){
                $yeuCauDoiHangID=$chiTietPhieuXuat->yeucaudoihang_id;//TRẢ VỀ ID CỦA YCDH
            }
        }


//dd($yeuCauDoiHang);
         $danhmucs=DanhMuc::all();
        // Trả về view với thông tin đơn hàng và tên khách hàng
        return view('taikhoans.khachhangs.chitietdonhang',
        compact('donhang','yeuCauDoiHangID','danhmucs'));
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
        $donhang->update(['trangThai' => 'Đã hủy']);
        $chiTietDonHangs=ChiTietDonHang::where('donhang_id', $donhang->id)->get();
        //dd($chiTietDonHangs);
        $sanpham_has_chitietdonhangs =collect();

        foreach($chiTietDonHangs as $chiTietDonHang){
            $sanpham=$chiTietDonHang->sanPhams;
            $sanpham_has_chitietdonhangs=$sanpham_has_chitietdonhangs->merge($sanpham);

        }
        //dd($sanpham_has_chitietdonhang);
        $sanphams=SanPham::all();
        foreach($sanpham_has_chitietdonhangs as $sanpham_has_chitietdonhang){
            foreach($sanphams as $sanpham){
                if($sanpham_has_chitietdonhang->id==$sanpham->id){
                    //dd($sanpham_has_chitietdonhang->pivot->soLuong);
                    $sanpham->soLuong+=$sanpham_has_chitietdonhang->pivot->soLuong;
                    $sanpham->save();
                    //dd($sanpham->soLuong);
                }
            }
        }

        return redirect()->route('khachhang.donhang.index')->with('huythanhcong', 'Đơn hàng đã được hủy.');
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



