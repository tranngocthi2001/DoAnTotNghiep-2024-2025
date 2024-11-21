<?php

namespace App\Http\Controllers\TaiKhoan\NhanVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nhanvien;

class DangKyController extends Controller
{
    public function register(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'tenTaiKhoan' => 'required|unique:nhanvien,tenTaiKhoan|max:100',
            'matKhau' => 'required|min:6|max:255',
            'email' => 'nullable|email|max:100',
            'vaiTro' => 'required|in:admin,quanly,nhanvien',
        ]);

        // Tạo tài khoản mới
        $nhanvien = Nhanvien::create([
            'tenTaiKhoan' => $request->tenTaiKhoan,
            'matKhau' => $request->matKhau, // Mã hóa đã được xử lý trong Model
            'email' => $request->email,
            'sdt' => $request->sdt,
            'diaChi' => $request->diaChi,
            'hoTen' => $request->hoTen,
            'vaiTro' => $request->vaiTro,
            'trangThai' => 1, // Trạng thái mặc định
        ]);

       // Return về view "success" với thông tin nhân viên
        return view('taikhoans.nhanviens.login', ['nhanvien' => $nhanvien]);
    }
        public function showRegisterForm()
    {
        return view('taikhoans/nhanviens/register');
    }

}
