<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class NhanVien extends Authenticatable
{
    use HasFactory;

    protected $table = 'nhanvien'; // Chỉ định bảng nhanvien

    protected $fillable = [
        'tenTaiKhoan',
        'matKhau',
        'email',
        'sdt',
        'diaChi',
        'hoTen',
        'vaiTro',
        'trangThai',
    ];

    protected $hidden = [
        'matKhau',
    ];
    // Thêm Accessor cho role user->role
    public function getRoleAttribute()
    {
        return $this->attributes['vaiTro'];
    }

    public $timestamps = true; // Bật chế độ tự động cập nhật thời gian

    const CREATED_AT = 'ngayTao'; // Tên trường "ngày tạo"
    const UPDATED_AT = 'ngayCapNhat'; // Tên trường "ngày cập nhật"

    // Sử dụng bcrypt để mã hóa mật khẩu khi lưu
    // public function setMatKhauAttribute($value)
    // {
    //     $this->attributes['matKhau'] = bcrypt($value);
    // }

    public function getAuthPassword()
    {
        return $this->matKhau; // Trả về giá trị của cột 'matKhau'
    }

    // Quan hệ 1-n với bảng PhieuXuatHang
    public function phieuXuatHangs()
    {
        return $this->hasMany(PhieuXuatHang::class, 'nhanvien_id');
    }
}



