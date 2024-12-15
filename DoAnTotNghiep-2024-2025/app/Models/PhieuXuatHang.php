<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuXuatHang extends Model
{
    use HasFactory;

    // Khai báo tên bảng
    protected $table = 'phieuxuathang';

    // Danh sách các cột có thể gán giá trị (fillable)
    protected $fillable = ['ngayXuat', 'trangThai', 'donhang_id', 'nhanvien_id'];

    // const UPDATED_AT = false; // Tên trường "ngày cập nhật"
    // const CREATED_AT = 'ngayXuat'; // Tên trường "ngày cập nhật"

    public $timestamps = false; // Bỏ qua các cột created_at và updated_at

    // Quan hệ với bảng DonHang (1 phiếu xuất thuộc về 1 đơn hàng)
    public function donHangs()
    {
        return $this->belongsTo(DonHang::class, 'donhang_id');
    }

    // Quan hệ với bảng NhanVien (1 phiếu xuất thuộc về 1 nhân viên)
    public function nhanViens()
    {
        return $this->belongsTo(NhanVien::class, 'nhanvien_id');
    }
     // Quan hệ 1-n: 1 phiếu xuất hàng có nhiều chi tiết phiếu xuất
     public function chiTietPhieuXuats()
     {
         return $this->hasMany(ChiTietPhieuXuat::class, 'phieuxuathang_id');
     }



}
