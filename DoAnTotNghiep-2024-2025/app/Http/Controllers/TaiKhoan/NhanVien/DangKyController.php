<?php


namespace App\Http\Controllers\TaiKhoan\NhanVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NhanVien;
use Illuminate\Support\Facades\Hash;

class DangKyController extends Controller
{
    public function register(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'tenTaiKhoan' => 'required|unique:nhanvien,tenTaiKhoan|max:100',
            'matKhau' => 'required|min:6|max:255|confirmed', // Xác nhận mật khẩu
            'email' => 'nullable|email|max:100',
            'vaiTro' => 'required|in:admin,quanly,nhanvien',
            'sdt' => 'nullable|max:15',
            'diaChi' => 'nullable|max:255',
            'hoTen' => 'nullable|max:255',
        ]);

        // Tạo tài khoản mới
        $nhanvien = NhanVien::create([
            'tenTaiKhoan' => $request->tenTaiKhoan,
            'matKhau' => Hash::make($request->matKhau), // Mã hóa mật khẩu
            'email' => $request->email,
            'sdt' => $request->sdt,
            'diaChi' => $request->diaChi,
            'hoTen' => $request->hoTen,
            'vaiTro' => $request->vaiTro,
            'trangThai' => 1, // Trạng thái mặc định là kích hoạt
        ]);

        // Chuyển hướng về trang đăng nhập
        return redirect()->route('login')->with('success', 'Đăng ký tài khoản thành công!');
    }

    public function showRegisterForm()
    {
        return view('taikhoans.nhanviens.register');
    }
}
