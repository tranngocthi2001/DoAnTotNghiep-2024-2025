<?php

namespace App\Http\Controllers\TaiKhoan\NhanVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DangNhapController extends Controller
{
    public function login(Request $request)
    {
        // Validate dữ liệu đầu vào
        $credentials = $request->validate([
            'tenTaiKhoan' => 'required',
            'matKhau' => 'required',
        ]);

        // Thử đăng nhập
        if (Auth::attempt(['tenTaiKhoan' => $credentials['tenTaiKhoan'], 'password' => $credentials['matKhau']])) {
            $nhanvien = Auth::user();

            // Kiểm tra vai trò của nhân viên
            if ($nhanvien->vaiTro === 'admin') {
                // Chuyển hướng đến trang quản lý cho admin
                return redirect()->route('admin.dashboard');
            }
            else if ($nhanvien->vaiTro === 'quanly') {
                // Chuyển hướng đến trang quản lý cho admin
                return redirect()->route('quanly.dashboard');
            }
            else if ($nhanvien->vaiTro === 'nhanvien') {
                // Chuyển hướng đến trang quản lý cho admin
                return redirect()->route('nhanvien.dashboard');
            }

            // Nếu không phải admin, chuyển hướng đến trang khác
            return redirect()->route('unauthorized'); // Hoặc bất kỳ trang nào khác
        }

        // Nếu đăng nhập thất bại, trả về trang "login" với lỗi
        return redirect()->route('login')->withErrors([
            'message' => 'Tên tài khoản hoặc mật khẩu không đúng',
        ]);
    }
    public function showLoginForm()
    {
        return view('taikhoans/nhanviens/login');
    }


}
