<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seri extends Model
{
    use HasFactory;

    protected $table = 'seri'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = ['maSeri', 'chitietphieuxuat_id']; // Các trường có thể gán giá trị

    public $timestamps = false; // Bỏ qua các cột created_at và updated_at

    // Quan hệ ngược lại với ChiTietPhieuXuat
    public function chiTietPhieuXuat()
    {
        return $this->belongsTo(ChiTietPhieuXuat::class, 'chitietphieuxuat_id');
    }
}
