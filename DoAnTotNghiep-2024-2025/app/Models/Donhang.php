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
        'updated_by'
    ];

    const CREATED_AT = 'ngayDatHang'; // Cột "ngày tạo"
    const UPDATED_AT = 'updated_by'; // Cột "ngày cập nhật"
    // Liên kết với khách hàng
    public function khachhang()
    {
        return $this->belongsTo(KhachHang::class, 'khachhang_id');
    }

    // Liên kết với nhân viên
    public function nhanvien()
    {
        return $this->belongsTo(NhanVien::class, 'nhanvien_id');
    }

    public function chitietdonhang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'donhang_id', 'id');
    }


}
