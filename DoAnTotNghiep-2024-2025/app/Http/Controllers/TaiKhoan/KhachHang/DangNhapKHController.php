<?php
namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Khachhang;
use Illuminate\Support\Facades\Hash;

class DangNhapKHController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        return view('taikhoans.khachhangs.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        // Validate dữ liệu từ form
        $request->validate([
            'tenTaiKhoan' => 'required|string',
            'matKhau' => 'required|string',
        ]);

        // Tìm khách hàng theo tên tài khoản
        $khachhang = Khachhang::where('tenTaiKhoan', $request->tenTaiKhoan)->first();

        if (!$khachhang) {
            return redirect()->back()->withErrors(['tenTaiKhoan' => 'Tên tài khoản không tồn tại!']);
        }

        // Kiểm tra mật khẩu
        if (!Hash::check($request->matKhau, $khachhang->matKhau)) {
            return redirect()->back()->withErrors(['matKhau' => 'Mật khẩu không đúng!']);
        }

        // Kiểm tra trạng thái tài khoản
        if ($khachhang->trangThai == 0) {
            return redirect()->back()->with('error', 'Tài khoản của bạn đã bị khóa!');
        }

        // Lưu thông tin đăng nhập vào session
        session(['khachhang' => $khachhang]);

        // Chuyển hướng tới trang dashboard
        return redirect()->route('khachhang.dashboard')->with('success', 'Đăng nhập thành công!');
    }

    /**
     * Xử lý đăng xuất
     */
    public function logout()
    {
        // Xóa session khách hàng
        session()->forget('khachhang');

        // Chuyển hướng về trang đăng nhập
        return redirect()->route('khachhang.loginForm')->with('success', 'Bạn đã đăng xuất thành công!');
    }
}
