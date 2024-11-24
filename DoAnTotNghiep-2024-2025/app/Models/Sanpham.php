<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanpham extends Model
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

    // Định nghĩa quan hệ với bảng Danhmuc (giả sử Danhmuc là một Model khác)
    public function danhmuc()
    {
        return $this->belongsTo(Danhmuc::class, 'danhmuc_id');
    }
    //sanpham và chitietgiohang quan hệ n-n
    public function chitietgiohangs()
    {
        return $this->belongsToMany(ChitietGiohang::class, 'sanpham_has_chitietgiohang', 'sanpham_id', 'chitietgiohang_id');
    }

}
