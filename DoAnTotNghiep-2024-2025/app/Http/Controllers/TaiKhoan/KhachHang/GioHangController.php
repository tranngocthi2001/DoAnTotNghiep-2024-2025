<?php

namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Models\Giohang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GioHangController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {

        // Lấy giỏ hàng của khách hàng hiện tại dựa trên ID
        $giohang = Giohang::where('khachhang_id', auth()->user()->id)->first();
        // Nếu giỏ hàng chưa tồn tại, tạo mới
        if (!$giohang) {
            $giohang = Giohang::create([
                'khachhang_id' => auth()->id(),
                'tongTien' => 0,
                'tongSoLuong' => 0,
            ]);
        }

        return view('taikhoans.khachhangs.giohang', compact('giohang'));
    }

    // Xóa giỏ hàng (nếu cần)
    public function destroy()
    {
        $giohang = Giohang::where('khachhang_id', auth()->id())->first();

        if ($giohang) {
            $giohang->chitietgiohang()->delete(); // Xóa tất cả chi tiết giỏ hàng
            $giohang->delete(); // Xóa giỏ hàng
        }

        return redirect()->route('giohang.index')->with('success', 'Giỏ hàng đã được xóa!');
    }
}
