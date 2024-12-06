<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YeuCauDoiHang extends Model
{
    use HasFactory;

    protected $table = 'yeucaudoihang';

    protected $fillable = [
        'ngayYeuCau',
        'lyDo',
        'trangThai',
    ];

    // Tắt cập nhật tự động nếu không sử dụng
    const CREATED_AT = 'ngayYeuCau';
    const UPDATED_AT = null;

    // Quan hệ nếu cần
    public function chitietdoihangs()
    {
        return $this->hasMany(ChiTietDoiHang::class, 'yeucaudoihang_id');
    }

    public function chitietPhieuxuat()
    {
        return $this->hasMany(ChiTietPhieuXuat::class, 'yeucaudoihang_id');
    }
}
