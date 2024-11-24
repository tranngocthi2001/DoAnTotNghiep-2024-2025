<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Khachhang;

class KhachHangCreated
{
    use Dispatchable;

    public $khachhang;

    public function __construct(Khachhang $khachhang)
    {
        $this->khachhang = $khachhang;
    }
}
