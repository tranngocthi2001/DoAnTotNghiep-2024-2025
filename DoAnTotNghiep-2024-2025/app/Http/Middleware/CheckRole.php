<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::guard('nhanvien')->user();

        // Kiểm tra nếu user không đăng nhập hoặc vai trò không khớp
        if (!$user || !in_array($user->vaiTro, $roles)) {
            return redirect('/unauthorized'); // Trang lỗi quyền truy cập
        }

        return $next($request);
    }
}
