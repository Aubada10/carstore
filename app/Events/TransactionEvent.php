<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nette\Utils\Strings;
use Ramsey\Uuid\Type\Integer;

class TransactionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $instance;
    public $box_id;
    public $car_id;
    public $amount;

    public function __construct($instance, $box_id, $car_id = null, $amount = 0.00)
    {
        $this->instance = $instance;
        $this->box_id = $box_id;
        $this->car_id = $car_id;
        $this->amount = $amount;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
