<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        if (!session('khachhang')) {
            return redirect()->route('khachhang.loginForm')->withErrors([
                'message' => 'Vui lòng đăng nhập để tiếp tục!',
            ]);
        }

        return $next($request);
    }
}
