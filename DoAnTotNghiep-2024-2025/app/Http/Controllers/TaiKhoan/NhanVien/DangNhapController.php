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

         // Thử đăng nhập với guard 'nhanvien'
         if (Auth::guard('nhanvien')->attempt([
            'tenTaiKhoan' => $credentials['tenTaiKhoan'],
            'password' => $credentials['matKhau']
        ])) {
            $nhanvien = Auth::guard('nhanvien')->user();

             // Thay đổi tên cookie cho guard 'nhanvien'
             config(['session.cookie' => 'nhanvien_session']); // Thay đổi tên cookie
            // Kiểm tra vai trò của nhân viên và lưu session cho nhanvien
            session(['nhanvien' => $nhanvien]); // Lưu nhân viên vào session

            if ($nhanvien->vaiTro === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($nhanvien->vaiTro === 'quanly') {
                return redirect()->route('quanly.dashboard');
            } elseif ($nhanvien->vaiTro === 'nhanvien') {
                return redirect()->route('nhanvien.dashboard');
            }
        }

        // Nếu đăng nhập thất bại
        return redirect()->route('login')->withErrors(['message' => 'Tên tài khoản hoặc mật khẩu không đúng.']);
    }

    public function showLoginForm()
    {
        return view('taikhoans.nhanviens.login');
    }
}

