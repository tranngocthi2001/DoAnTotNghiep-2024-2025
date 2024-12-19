<?php

namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Models\GioHang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\KhachHang;

class GioHangController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        //$khachhang = session('khachhang');
        //dd($khachhang);
        $danhmucs = DanhMuc::all();

        $khachhang=KhachHang::where('id',auth()->user()->id)->first();
        //dd($khachhang);

        $giohang = GioHang::firstOrCreate(
            ['khachhang_id' => $khachhang->id],
            ['tongTien' => 0, 'tongSoLuong' => 0]
        );

        // Lấy giỏ hàng của khách hàng hiện tại dựa trên ID
        $giohang = GioHang::where('khachhang_id', auth()->user()->id)->first();
//dd($giohang);

        return view('taikhoans.khachhangs.giohang', compact('giohang','danhmucs'));
    }

    // Xóa giỏ hàng (nếu cần)
    public function destroy()
    {
        $giohang = GioHang::where('khachhang_id', auth()->id())->first();

        if ($giohang) {
            $giohang->chiTietGioHangs()->delete(); // Xóa tất cả chi tiết giỏ hàng
            $giohang->delete(); // Xóa giỏ hàng
        }

        return redirect()->route('giohang.index')->with('success', 'Giỏ hàng đã được xóa!');
    }
}
