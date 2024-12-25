<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $khachhang;

    public function __construct($khachhang)
    {
        $this->khachhang = $khachhang;
    }

    public function build()
    {
        return $this->subject('Chào mừng bạn đến với chúng tôi!')
                    ->view('emails.welcome');  // Đảm bảo bạn đã tạo view 'emails.welcome'
    }
}
