<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;

    protected $table = 'danhmuc'; // Tên bảng trong database

    protected $primaryKey = 'id'; // Khóa chính của bảng

    protected $fillable = [
        'tenDanhMuc',
        'moTa',
        'ngayTao',
        'ngayCapNhat',
        'trangThai',
    ];

    public $timestamps = true; // Tự động quản lý created_at và updated_at

    const CREATED_AT = 'ngayTao'; // Cột "ngày tạo"
    const UPDATED_AT = 'ngayCapNhat'; // Cột "ngày cập nhật"
    public function sanPhams()
    {
        return $this->hasMany(Sanpham::class, 'danhmuc_id', 'id');
    }
}
