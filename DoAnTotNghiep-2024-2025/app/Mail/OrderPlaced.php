<?php

namespace App\Mail;

use App\Models\DonHang;  // Đảm bảo bạn đã import đúng model DonHang
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $donhang;

    /**
     * Tạo một phiên bản mới của lớp.
     *
     * @param  \App\Models\DonHang  $donhang
     * @return void
     */
    public function __construct(DonHang $donHang)
    {
        $this->donhang = $donHang;
    }

    /**
     * Định nghĩa nội dung của email.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->view('emails.order_placed')  // Tạo view email của bạn tại resources/views/emails/order_placed.blade.php
                    ->subject('Đặt hàng thành công');
    }
}
