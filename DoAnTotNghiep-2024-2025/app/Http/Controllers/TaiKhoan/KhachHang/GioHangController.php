<?php

namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Models\Giohang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Khachhang;

class GioHangController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {

        $khachhang=Khachhang::where('id',auth()->user()->id)->first();
        //dd($khachhang);
        // Lấy giỏ hàng của khách hàng hiện tại dựa trên ID
        $giohang = Giohang::where('khachhang_id', auth()->user()->id)->first();
//dd($giohang);

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
