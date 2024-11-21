<?php

return [

    'defaults' => [
        'guard' => 'web', // Guard mặc định
        'passwords' => 'nhanviens', // Tên provider password (nếu có reset mật khẩu)
    ],

    'guards' => [
        'web' => [
            'driver' => 'session', // Sử dụng session
            'provider' => 'nhanviens', // Khớp với tên provider
        ],
        'api' => [
            'driver' => 'token', // Dùng token cho API
            'provider' => 'nhanviens', // Khớp với tên provider
            'hash' => false,
        ],
    ],

    'providers' => [
        'nhanviens' => [ // Tên provider
            'driver' => 'eloquent', // Dùng Eloquent ORM
            'model' => App\Models\Nhanvien::class, // Đường dẫn đầy đủ đến model
        ],
    ],


    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
