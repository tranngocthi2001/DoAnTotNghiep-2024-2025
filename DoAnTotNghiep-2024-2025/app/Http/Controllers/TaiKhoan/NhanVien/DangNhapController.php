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

            return response()->json([
                'message' => 'Đăng nhập thành công',
                'nhanvien' => $nhanvien,
            ], 200);
        }

        // Thông báo lỗi nếu thông tin không chính xác
        return response()->json([
            'message' => 'Tên tài khoản hoặc mật khẩu không đúng',
        ], 401);
    }
}
