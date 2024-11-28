<?php

namespace App\Listeners;

use App\Events\CompanyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CompanyListener
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
    public function handle(CompanyEvent $event): void
    {
        $newvalue = $event->company->wallet + $event->price;
        $event->company->update([
            'wallet' => $newvalue
        ]);
    }
}
