<?php

namespace App\Listeners;

use App\Events\BoxEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BoxListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BoxEvent $event): void
    {
        $newvalue = $event->box->value + $event->price;
        $event->box->update([
            'value' => $newvalue
        ]);
    }
}
