<?php

return [

    'defaults' => [
        // 'guard' => 'nhanvien',
        // 'passwords' => 'nhanviens',
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
            'provider' => 'khachhangs', // Trỏ tới provider 'khachhang'
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
        'nhanviens' => [
            'provider' => 'nhanviens',
            'table' => 'password_resets', // Bảng lưu mã đặt lại mật khẩu cho nhân viên
            'expire' => 60,
            'throttle' => 60,
        ],
        'khachhangs' => [
            'provider' => 'khachhangs',
            'table' => 'password_resets', // Bảng lưu mã đặt lại mật khẩu cho khách hàng
            'expire' => 60,
            'throttle' => 60,
        ],
    ],


    'password_timeout' => 10800, // 3 giờ

];
