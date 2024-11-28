<?php

namespace App\Listeners;

use App\Events\UserEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserListener
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
    public function handle(UserEvent $event): void
    {
        $newvalue = $event->user->wallet + $event->value;
        $event->user->update([
            'wallet' => $newvalue
        ]);
    }
}
