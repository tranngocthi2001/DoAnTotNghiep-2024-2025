<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KiemTraDangNhapKhachHang
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra khách hàng đã đăng nhập hay chưa
        if (!Auth::guard('khachhang')->check()) {
            return redirect()->route('khachhang.showLoginForm')->withErrors([
                'message' => 'Vui lòng đăng nhập để tiếp tục!',
            ]);
        }

        // Cho phép request tiếp tục nếu đã đăng nhập
        return $next($request);
    }
}
