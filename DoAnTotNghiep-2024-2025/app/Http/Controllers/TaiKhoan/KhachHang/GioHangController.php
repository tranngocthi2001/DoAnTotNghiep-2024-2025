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
//dd($giohang);

        return view('taikhoans.khachhangs.giohang', compact('giohang','danhmucs'));
    }

}
