<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VanChuyen extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu tên bảng không phải là số nhiều của model
    protected $table = 'vanchuyen';

    // Các cột có thể được gán mass assignable
    protected $fillable = [
        'tenVanChuyen',
        'trangThaiVanChuyen',
        'ngayGiaoDuKien',
        'ngayThucTe',
        'maVanChuyen',
        'donhang_id',
    ];
    const CREATED_AT = false; // Cột "ngày tạo"
    const UPDATED_AT = false;
    // Định nghĩa quan hệ 1-1 với DonHang
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'donhang_id');
    }
}
