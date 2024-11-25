<?php
namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Http\Controllers\Controller;


use App\Models\DonHang;
use App\Models\Giohang;
use App\Models\ChiTietDonHang;

use Illuminate\Http\Request;

class DonHangKHController extends Controller
{

    public function index()
    {
         // Lấy danh sách đơn hàng của khách hàng hiện tại
        $donhangs = DonHang::where('khachhang_id', auth()->user()->id)->get();
        //dd($donhangs);
        return view('taikhoans.khachhangs.donhang', compact('donhangs'));
    }

    public function donHangCreate(Request $request)
    {
        // Lấy giỏ hàng của khách hàng hiện tại
        $giohang = GioHang::with('chitietgiohang.sanphams', 'khachhang')
            ->where('khachhang_id', auth()->user()->id)
            ->first();

        if (!$giohang || $giohang->tongTien <= 0 || $giohang->chitietgiohang->isEmpty()) {
            return redirect()->route('giohang.index')->withErrors('Giỏ hàng của bạn trống hoặc không hợp lệ!');
        }

        // Tạo đơn hàng
        $donHang = DonHang::create([
            'khachhang_id' => $giohang->khachhang_id,
            'tongTien' => $giohang->tongTien,
            'trangThai' => 'Chưa xác nhận',
            'diaChiGiaoHang' => $request->input('diaChi', $giohang->khachhang->diaChi),
            'sdt' => $request->input('sdt', $giohang->khachhang->sdt),
            'ngayDatHang' => now(),
        ]);

        // Lưu chi tiết đơn hàng và bảng liên kết
        foreach ($giohang->chitietgiohang as $chitietgiohang) {
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
            $donhang = DonHang::with('chitietdonhang.sanphams')->findOrFail($id);
//dd($donhang);
            // Kiểm tra xem đơn hàng có thuộc về khách hàng hiện tại không
            // if ($donhang->khachhang_id !== auth()->id()) {
            //     return redirect()->route('khachhang.donhang.index')->withErrors('Bạn không có quyền xem chi tiết đơn hàng này.');
            // }

            return view('taikhoans.khachhangs.chitietdonhang', compact('donhang'));
        }

}



