<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    use HasFactory;
    use HasFactory;

    // Định nghĩa bảng sử dụng trong database (nếu bảng không theo tên mặc định "payments")
    protected $table = 'thanhtoan'; // Tên bảng trong database

    // Định nghĩa các cột có thể được gán đại diện
    protected $fillable = [
        'donhang_id',
        'phuongThuc',
        'soTien',
        'trangThaiGiaoDich',
        'ngayGiaoDich',
        'maGiaoDichNganHang',
        'maGiaoDichMomo',
    ];

    // Quan hệ giữa Payment và DonHang
    public function donhang()
    {
        // Bảng thanh toán thuộc về bảng đơn hàng
        return $this->belongsTo(DonHang::class, 'donhang_id');
    }
}
