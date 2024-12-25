<?php

namespace App\Mail;

use App\Models\SanPham;  // Đảm bảo đã import model SanPham
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductLowStockNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $sanPham; // SanPham mà số lượng dưới 10

    /**
     * Tạo một thông báo mới.
     *
     * @param  \App\Models\SanPham  $sanPham
     * @return void
     */
    public function __construct(SanPham $sanPham)
    {
        $this->sanPham = $sanPham;
    }

    /**
     * Định nghĩa nội dung email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Cảnh báo: Sản phẩm còn ít')
                    ->view('emails.product_low_stock');
    }
}
