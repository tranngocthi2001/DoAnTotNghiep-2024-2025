<?php
namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Http\Controllers\Controller;


use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\ChiTietDonHang;
use App\Models\KhachHang;
use Illuminate\Http\Request;

class DonHangKHController extends Controller
{

    // Hiển thị đơn hàng cho khách hàng và chọn phương thức thanh toán
    public function dondathang()
    {
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
        ]);
    }
    public function index()
    {
         // Lấy danh sách đơn hàng của khách hàng hiện tại
        $donhangs = DonHang::where('khachhang_id', auth()->user()->id)
        ->orderBy('ngayDatHang', 'desc')->get();
        //dd($donhangs);
        return view('taikhoans.khachhangs.donhang', compact('donhangs'));
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
        $khachhang=$giohang->khachHang;

        return view('taikhoans.khachhangs.chitietdonhang', compact('donhang','khachhang'));
    }


}



