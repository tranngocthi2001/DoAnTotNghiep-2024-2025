<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChitietGiohang extends Model
{
    use HasFactory;

    protected $table = 'chitietgiohang'; // Tên bảng trong cơ sở dữ liệu
    protected $fillable = ['soLuong', 'gia', 'giohang_id']; // Các trường có thể điền giá trị

    //quan hệ n-n
    public function sanphams()
    {
        return $this->belongsToMany(Sanpham::class, 'sanpham_has_chitietgiohang', 'chitietgiohang_id', 'sanpham_id');
    }


    public function giohang()
    {
        return $this->belongsTo(Giohang::class, 'giohang_id');
    }

}