<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;

    // Tên bảng trong database
    protected $table = 'sanpham'; // Đổi tên bảng nếu bảng trong DB có tên khác

    // Khóa chính
    protected $primaryKey = 'id';

    // Tắt chế độ timestamps mặc định của Laravel nếu không cần (nếu không có created_at, updated_at)
    public $timestamps = false;

    // Các cột trong bảng được phép thêm/sửa
    protected $fillable = [
        'tenSanPham',
        'moTa',
        'gia',
        'hinhAnh',
        'ngayTao',
        'ngayCapNhat',
        'soLuong',
        'trangThai',
        'danhmuc_id',
    ];

    public function danhMucs()
    {
        return $this->belongsTo(Danhmuc::class, 'danhmuc_id');
    }
    //sanpham và chitietgiohang quan hệ n-n
    public function chiTietGioHangs()
    {
        return $this->belongsToMany(ChitietGiohang::class, 'sanpham_has_chitietgiohang', 'sanpham_id', 'chitietgiohang_id')
        ->withPivot('soLuong');
    }
    public function chiTietDonHangs()
    {
        return $this->belongsToMany(ChiTietDonHang::class, 'sanpham_has_chitietdonhang', 'sanpham_id', 'chitietdonhang_id')
            ->withPivot('soLuong');
    }


}
