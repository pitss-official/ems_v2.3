<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrepareQRSheetForSmartCardsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $QRArray;
    public $email;

    /**
     * Create a new event instance.
     *
     * @param $QRArray
     * @param $email
     */
    public function __construct($QRArray,$email)
    {
        $this->QRArray = $QRArray;
        $this->email = $email;
    }
}
