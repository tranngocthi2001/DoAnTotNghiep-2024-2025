<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuXuat extends Model
{
    use HasFactory;
    protected $table = 'chitietphieuxuat'; // Tên bảng trong cơ sở dữ liệu

    protected $fillable = ['soLuong', 'baoHanh', 'ghiChu', 'chitietdonhang_id', 'phieuxuathang_id'];

    public $timestamps = false; // Bỏ qua các cột created_at và updated_at

    // Quan hệ với phiếu xuất hàng
    public function phieuXuatHangs()
    {
        return $this->belongsTo(PhieuXuatHang::class, 'phieuxuathang_id');
    }

    // Quan hệ với chi tiết đơn hàng để lấy thông tin sản phẩm
    public function chiTietDonHangs()
    {
        return $this->belongsTo(ChiTietDonHang::class, 'chitietdonhang_id');
    }
    // Quan hệ với Seri (mỗi chi tiết phiếu xuất có thể có nhiều mã seri)
    public function seris()
    {
        return $this->hasMany(Seri::class, 'chitietphieuxuat_id');
    }
}
