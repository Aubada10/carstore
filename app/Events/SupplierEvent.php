<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SupplierEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $supplier;
    public $price;
    /**
     * Create a new event instance.
     */
    public function __construct($supplier, $price)
    {
        $this->supplier = $supplier;
        $this->price = $price;
    }
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
