<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDoiHang extends Model
{
    use HasFactory;
    protected $table = 'chitietdoihang';
    protected $fillable = [
         'yeucaudoihang_id',
          'sanPhamDoiID',
          'soLuong',
          'hinhAnh',
     ];
     public $timestamps = false; // Bỏ qua các cột created_at và updated_at
     public function YeucauDoihang()
     {
        return $this->belongsTo(YeuCauDoiHang::class, 'yeucaudoihang_id');
    }
    public function chitietPhieuxuat()
    {
        return $this->belongsTo(ChiTietPhieuXuat::class, 'chitiet_phieuxuat_id');
    }
}
