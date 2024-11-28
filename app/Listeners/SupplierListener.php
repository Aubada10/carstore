<?php

namespace App\Listeners;

use App\Events\SupplierEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SupplierListener
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
    public function handle(SupplierEvent $event): void
    {
        $newvalue = $event->supplier->wallet + $event->price;
        $event->supplier->update([
            'wallet' => $newvalue
        ]);
    }
}
