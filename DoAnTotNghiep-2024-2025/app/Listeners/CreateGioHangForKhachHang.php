<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Giohang;
use App\Events\KhachHangCreated;

class CreateGioHangForKhachHang
{
    public function handle(KhachHangCreated $event)
{
    // Kiểm tra xem khách hàng đã có giỏ hàng chưa
    if (!$event->khachhang->giohang) {
        Giohang::create([
            'khachhang_id' => $event->khachhang->id,
            'tongTien' => 0,
            'tongSoLuong' => 0,
        ]);
    }
}

}
