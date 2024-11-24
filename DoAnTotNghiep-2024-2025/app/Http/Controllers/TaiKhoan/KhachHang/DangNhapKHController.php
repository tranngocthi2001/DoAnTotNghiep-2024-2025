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
        // Kiểm tra thông tin tài khoản
        $credentials = [
            'tenTaiKhoan' => $request->tenTaiKhoan,
            'password' => $request->matKhau,
        ];

         // Sử dụng guard 'khachhang' để kiểm tra đăng nhập
        if (Auth::guard('khachhang')->attempt($credentials)) {
            // Kiểm tra trạng thái tài khoản
            $khachhang = Auth::guard('khachhang')->user();
            if ($khachhang->trangThai == 0) {
                Auth::guard('khachhang')->logout(); // Đăng xuất ngay nếu tài khoản bị khóa
                return redirect()->back()->withErrors(['error' => 'Tài khoản của bạn đã bị khóa!']);
            }

            // Đăng nhập thành công, chuyển hướng đến dashboard
            return redirect()->route('khachhang.dashboard')->with('success', 'Đăng nhập thành công!');
        }
        //dd($request->all());

        // Nếu thông tin đăng nhập không đúng
        return redirect()->back()->withErrors(['error' => 'Tên tài khoản hoặc mật khẩu không đúng.']);
        }

    /**
     * Xử lý đăng xuất
     */
    public function logout()
    {
        // Xóa session khách hàng
        session()->forget('khachhang');

        // Chuyển hướng về trang đăng nhập
        return redirect()->route('khachhang.showLoginForm')->with('success', 'Bạn đã đăng xuất thành công!');
    }
}
