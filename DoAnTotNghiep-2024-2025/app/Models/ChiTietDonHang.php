<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    use HasFactory;

    protected $table = 'chitietdonhang'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = [
        'soLuong',
        'gia',
        'donhang_id',
    ];

    public $timestamps = false; // Bảng không có cột thời gian created_at và updated_at

    /**
     * Quan hệ với bảng DonHang
     */
    public function donhang()
    {
        return $this->belongsTo(DonHang::class, 'donhang_id', 'id');
    }
    public function sanphams()
    {
        return $this->belongsToMany(SanPham::class, 'sanpham_has_chitietdonhang', 'chitietdonhang_id', 'sanpham_id')
            ->withPivot('soLuong');
    }
}