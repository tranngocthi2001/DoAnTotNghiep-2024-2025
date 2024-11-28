<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Authenticatable
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


     public function getAuthIdentifierName()
    {
        return 'tenTaiKhoan'; // Laravel sẽ sử dụng trường này làm khóa đăng nhập
    }

    public function getAuthPassword()
    {
        return $this->matKhau; // Laravel sẽ sử dụng trường này để kiểm tra mật khẩu
    }
    public function donHangs()
    {
        return $this->hasMany(DonHang::class, 'khachhang_id', 'id');
    }
   // Quan hệ 1-1 với giỏ hàng
   public function gioHangs()
   {
       return $this->hasOne(GioHang::class, 'khachhang_id', 'id');
   }


}
