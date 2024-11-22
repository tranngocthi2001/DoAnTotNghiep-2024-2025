<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckNhanVienStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user(); // Lấy thông tin nhân viên đăng nhập (mặc định sử dụng guard `web`)

        // Kiểm tra trạng thái tài khoản
        if ($user && $user->trangThai == 0) {
            return redirect()->route('unauthorized') // Chuyển hướng đến trang từ chối quyền truy cập
                ->with('error', 'Tài khoản của bạn đã bị khóa! Vui lòng liên hệ quản trị viên.');
        }

        return $next($request); // Cho phép tiếp tục truy cập nếu trạng thái hợp lệ
    }
}
