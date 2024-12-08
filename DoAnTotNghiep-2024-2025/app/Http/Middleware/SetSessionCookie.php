<?php
namespace App\Http\Middleware;

use Closure;

class SetSessionCookie
{
    public function handle($request, Closure $next)
    {
        if ($request->routeIs('nhanvien.*')) {
            config(['session.cookie' => env('SESSION_COOKIE_NHANVIEN')]);
        } elseif ($request->routeIs('khachhang.*')) {
            config(['session.cookie' => env('SESSION_COOKIE_KHACHHANG')]);
        }
        return $next($request);
    }
}
