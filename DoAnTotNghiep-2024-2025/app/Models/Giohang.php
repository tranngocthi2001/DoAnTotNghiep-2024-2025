<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giohang extends Model
{
    use HasFactory;

    protected $table = 'giohang'; // Tên bảng trong cơ sở dữ liệu
    protected $fillable = ['tongTien', 'tongSoLuong', 'khachhang_id']; // Các trường có thể điền giá trị
    public $timestamps = false; // Bỏ qua các cột created_at và updated_at

    // Quan hệ 1-1 với khách hàng
    public function khachhang()
{
    return $this->belongsTo(KhachHang::class, 'khachhang_id', 'id');
}


    // Quan hệ 1-n với chi tiết giỏ hàng
    public function chitietgiohang()
    {
        return $this->hasMany(ChiTietGioHang::class, 'giohang_id', 'id');
    }

}
