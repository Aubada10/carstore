<?php

namespace App\Listeners;

use App\Events\TransactionEvent;
use App\Models\Car;
use App\Models\Company;
use App\Models\Deal;
use App\Models\Installment;
use App\Models\Transaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TransactionListener
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
    public function handle(TransactionEvent $event): void
    {
        if ($event->instance instanceof Car) {
            Transaction::create([
                'value' => - ($event->instance->price),
                'date' => now(),
                'box_id' => $event->box_id,
                'car_id' => $event->instance->car_id,
                'description' => "pay for car number " . $event->instance->car_id
            ]);
        } elseif ($event->instance instanceof Deal) {

            if ($event->instance->type == "cash") {
                Transaction::create([
                    'value' =>  $event->instance->total_cost,
                    'date' => now(),
                    'box_id' => $event->box_id,
                    'deal_id' => $event->instance->deal_id,
                    'description' => "get paid for cash deal number " . $event->instance->deal_id . " and car number " . $event->car_id,
                ]);
            } else {
                foreach ($event->instance->installments as $installment) {
                    Transaction::create([
                        'value' =>  $installment->amount,
                        'date' => now(),
                        'box_id' => $event->box_id,
                        'deal_id' => $event->instance->deal_id,
                        'description' => "pay for deal number " . $event->instance->deal_id . " installment number " . $installment->installment_id,
                    ]);
                }
            }
        } elseif ($event->instance instanceof Company) {
            Transaction::create([
                'value' => - ($event->amount),
                'date' => now(),
                'box_id' => $event->box_id,
                'car_id' => $event->car_id,
                'description' => "pay for car " . $event->instance->type
                    . " costs for car number " . $event->car_id
                    . " to " . $event->instance->name . " company"
            ]);
        } elseif ($event->instance instanceof Installment) {
            Transaction::create([
                'value' =>  $event->instance->amount,
                'date' => now(),
                'box_id' => $event->box_id,
                'deal_id' => $event->instance->deal_id,
                'description' => "get paid  for installment number " . $event->instance->installment_id . " of deal number " . $event->instance->deal_id
            ]);
        }
    }
}
