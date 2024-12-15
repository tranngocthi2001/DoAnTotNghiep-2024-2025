<?php

namespace App\Http\Controllers\TaiKhoan\NhanVien;

use App\Http\Controllers\Controller;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DangNhapController extends Controller
{
    public function login(Request $request)
    {
        // Validate dữ liệu từ form
        $request->validate([
            'tenTaiKhoan' => 'required|string',
            'matKhau' => 'required|string',
        ]);

        $nhanvien= NhanVien::where('tenTaiKhoan', $request->tenTaiKhoan)->first();
        //dd($nhanvien);

        if (!$nhanvien) {
            return redirect()->back()->withErrors(['tenTaiKhoan' => 'Tên tài khoản không tồn tại!']);
        }
        if ($nhanvien->trangThai == 0) {
            return redirect()->back()->with('error', 'Tài khoản của bạn đã bị khóa!');
        }
        // Kiểm tra thông tin tài khoản
        $credentials = [
            'tenTaiKhoan' => $request->tenTaiKhoan,
            'password' => $request->matKhau,
        ];


        // Sử dụng guard 'khachhang' để kiểm tra đăng nhập
        if (Auth::guard('nhanvien')->attempt($credentials)) {
            // Kiểm tra trạng thái tài khoản

            $nhanvien = Auth::guard('nhanvien')->user();
            //dd($nhanvien);

             // Thay đổi tên cookie cho guard 'nhanvien'
             //config(['session.cookie' => 'nhanvien_session']); // Thay đổi tên cookie
            // Kiểm tra vai trò của nhân viên và lưu session cho nhanvien
            session(['nhanvien' => $nhanvien]); // Lưu nhân viên vào session

            if ($nhanvien->vaiTro === 'admin') {
                //dd(session()->get('nhanvien'));

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
    /**
     * Xử lý đăng xuất
     */
    public function logout()
    {
        // Xóa session khách hàng
        session()->forget('nhanvien');

        // Chuyển hướng về trang đăng nhập
        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất thành công!');
    }
}

