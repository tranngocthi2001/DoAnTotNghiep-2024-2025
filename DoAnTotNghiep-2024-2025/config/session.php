<?php

use Illuminate\Support\Str;

return [



    'driver' => env('SESSION_DRIVER', 'file'),

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    'encrypt' => false,

    'files' => storage_path('framework/sessions'),



    'connection' => env('SESSION_CONNECTION'),



    'table' => 'sessions',



    'store' => env('SESSION_STORE'),



    'lottery' => [2, 100],

    // 'cookie' => function () {
    //     // Kiểm tra tên route hiện tại để xác định guard
    //     if (request()->routeIs('nhanvien.*')) {
    //         return env('SESSION_COOKIE_NHANVIEN', 'nhanvien_session');
    //     } elseif (request()->routeIs('khachhang.*')) {
    //         return env('SESSION_COOKIE_KHACHHANG', 'khachhang_session');
    //     }

    //     // Mặc định
    //     return env('SESSION_COOKIE', 'laravel_session');
    // },

    'cookie' => env('SESSION_COOKIE', 'laravel_session'),



    // 'cookie' => env(
    //     'SESSION_COOKIE',
    //     Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    // ),
    // config/session.php
    //'cookie' => 'nhanvien_session',
    // 'cookie' => env('SESSION_COOKIE', 'laravel_session'),



    'path' => '/',


    'domain' => env('SESSION_DOMAIN'),



    'secure' => env('SESSION_SECURE_COOKIE'),



    'http_only' => true,


    'same_site' => 'lax',

];
