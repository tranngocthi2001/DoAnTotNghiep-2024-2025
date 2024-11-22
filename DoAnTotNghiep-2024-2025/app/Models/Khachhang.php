<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khachhang extends Model
{
    use HasFactory;

    protected $table = 'khachhang'; // Tên bảng trong database

    protected $primaryKey = 'id'; // Khóa chính của bảng

    protected $fillable = [
        'tenTaiKhoan',
        'matKhau',
        'email',
        'sdt',
        'diaChi',
        'hoTen',
        'trangThai',
        'danhgia_id',
    ];

    protected $hidden = [
        'matKhau', // Ẩn mật khẩu khi trả về JSON
    ];

    public $timestamps = true; // Laravel tự động quản lý cột created_at và updated_at

    const CREATED_AT = 'ngayTao'; // Cột "ngày tạo"
    const UPDATED_AT = 'ngayCapNhat'; // Cột "ngày cập nhật"
}
