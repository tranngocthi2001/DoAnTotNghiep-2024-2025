<?php

namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\KhachHang;
use App\Events\KhachHangCreated;
use Illuminate\Support\Facades\DB;

class DangKyKHController extends Controller
{
    public function showRegistrationForm()
    {
        return view('taikhoans.khachhangs.register');
    }

    public function handleRegistration(Request $request)
    {
        $request->validate([
            'tenTaiKhoan' => 'required|string|max:50|unique:khachhang,tenTaiKhoan',
            'matKhau' => 'required|string|min:6|confirmed',
            'email' => 'required|email|unique:khachhang,email',
            'sdt' => 'required|digits:10',
            'diaChi' => 'nullable|string|max:255',
            'hoTen' => 'required|string|max:100',
        ]);

        // Tạo khách hàng mới
        try {
            $khachhang = KhachHang::create([
                'tenTaiKhoan' => $request->tenTaiKhoan,
                'matKhau' => Hash::make($request->matKhau),
                'email' => $request->email,
                'sdt' => $request->sdt,
                'diaChi' => $request->diaChi,
                'hoTen' => $request->hoTen,
                'trangThai' => 1,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Có lỗi xảy ra khi tạo tài khoản. Vui lòng thử lại!']);
        }
//dd($khachhang);
        // Kích hoạt event
         event(new KhachHangCreated($khachhang));
                 return redirect()->route('khachhang.showLoginForm')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}
