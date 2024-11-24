<?php

return [

    'defaults' => [
        'guard' => 'khachhang', // Sử dụng guard 'nhanvien' mặc định
        'passwords' => 'khachhangs', // Đặt lại passwords nếu cần
    ],

    'guards' => [
        'nhanvien' => [
            'driver' => 'session',
            'provider' => 'nhanviens',
        ],
        'khachhang' => [
            'driver' => 'session', // Dùng session để lưu trạng thái đăng nhập
            'provider' => 'khachhangs', // Trỏ tới provider 'khachhangs'
        ],
    ],


    'providers' => [
        'nhanviens' => [
            'driver' => 'eloquent',
            'model' => App\Models\NhanVien::class, // Model của nhân viên
        ],
        'khachhangs' => [
            'driver' => 'eloquent',
            'model' => App\Models\KhachHang::class, // Model của khách hàng
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
