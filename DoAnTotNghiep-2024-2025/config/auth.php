<?php

return [

    'defaults' => [
        'guard' => 'nhanvien', // Sử dụng guard 'nhanvien' mặc định
        'passwords' => 'nhanviens', // Đặt lại passwords nếu cần
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'nhanviens', // Đã trỏ đúng provider
        ],

        'nhanvien' => [ // Định nghĩa thêm guard 'nhanvien'
            'driver' => 'session',
            'provider' => 'nhanviens',
        ],
    ],

    'providers' => [
        'nhanviens' => [ // Provider cho NhanVien
            'driver' => 'eloquent',
            'model' => App\Models\NhanVien::class,
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
