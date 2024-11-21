<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nhanvien;
use Illuminate\Support\Facades\Auth;

class TaikhoanController extends Controller
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
            'matKhau' => bcrypt($request->matKhau), // Mã hóa mật khẩu
            'email' => $request->email,
            'sdt' => $request->sdt,
            'diaChi' => $request->diaChi,
            'hoTen' => $request->hoTen,
            'vaiTro' => $request->vaiTro,
            'trangThai' => 1, // Trạng thái mặc định là active
        ]);

        // Trả về phản hồi JSON
        return response()->json([
            'message' => 'Đăng ký thành công',
            'nhanvien' => $nhanvien
        ]);
    }
    public function login(Request $request)
{
    // Kiểm tra dữ liệu đầu vào
    $credentials = $request->validate([
        'tenTaiKhoan' => 'required',
        'matKhau' => 'required',
    ]);

    // Thử xác thực
    if (Auth::guard('web')->attempt([
        'tenTaiKhoan' => $credentials['tenTaiKhoan'],
        'matKhau' => $credentials['matKhau']
    ])) {
        // Lấy thông tin nhân viên
        $nhanvien = Auth::guard('web')->user();

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'nhanvien' => $nhanvien
        ]);
    }

    // Trả về thông báo lỗi nếu thông tin không chính xác
    return response()->json([
        'message' => 'Tên tài khoản hoặc mật khẩu không đúng'
    ], 401);
}
}
