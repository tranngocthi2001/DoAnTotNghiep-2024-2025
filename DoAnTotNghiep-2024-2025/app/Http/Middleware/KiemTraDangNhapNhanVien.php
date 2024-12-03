<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KiemTraDangNhapNhanVien
{

    public function handle($request, Closure $next, ...$roles)
    {
        $user = auth()->guard('nhanvien')->user();

        // Debug user và vai trò
        dd($user, $user->role);

        if (!$user || !in_array($user->role, $roles)) {
            return redirect()->route('login')->withErrors('Bạn 1không có quyền truy cập.');
        }

        return $next($request);
    }


}
