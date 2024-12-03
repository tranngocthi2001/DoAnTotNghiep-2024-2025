<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Type\NullType;

class DonHang extends Model
{
    use HasFactory;

    protected $table = 'donhang'; // Tên bảng trong CSDL

    protected $fillable = [
        'khachhang_id',
        'nhanvien_id',
        'tongTien',
        'trangThai',
        'diaChiGiaoHang',
        'sdt',
        'ngayDatHang',
        'updated_by',
        'phuongThucThanhToan',
        'tenKhachHang',
        'maVanChuyen'
    ];

    const CREATED_AT = 'ngayDatHang'; // Cột "ngày tạo"
    const UPDATED_AT = 'updated_by'; // Cột "ngày cập nhật"
    // Liên kết với khách hàng
    public function khachHangs()
    {
        return $this->belongsTo(KhachHang::class, 'khachhang_id');
    }

    // Liên kết với nhân viên
    public function nhanViens()
    {
        return $this->belongsTo(NhanVien::class, 'nhanvien_id');
    }

    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'donhang_id', 'id');
    }

// Quan hệ 1-n với bảng PhieuXuatHang
    public function phieuXuatHangs()
    {
        return $this->hasMany(PhieuXuatHang::class, 'donhang_id');
    }
    public function thanhtoan()
    {
        // Một đơn hàng sẽ có một thanh toán
        return $this->hasOne(ThanhToan::class, 'donhang_id');
    }
     // Định nghĩa quan hệ 1-1 với VanChuyen
     public function vanChuyen()
     {
        return $this->hasOne(VanChuyen::class, 'donhang_id');
     }
}
