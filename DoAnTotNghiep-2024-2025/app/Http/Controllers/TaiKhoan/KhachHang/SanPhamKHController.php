<?php

namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Models\GioHang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc;

use App\Models\SanPham;

class SanPhamKHController extends Controller
{// Hiển thị chi tiết một sản phẩm
    public function show($id)
    {
        $danhmucs= DanhMuc::all();
        $sanpham = SanPham::with('danhMucs')->findOrFail($id);
        return view('taikhoans.khachhangs.chitietsanpham', compact('sanpham','danhmucs'));
    }
}
