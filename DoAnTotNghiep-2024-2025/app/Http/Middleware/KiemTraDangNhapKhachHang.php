<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KiemTraDangNhapKhachHang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
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
