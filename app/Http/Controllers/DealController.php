<?php

namespace App\Http\Controllers;

use App\Events\BoxEvent;
use App\Events\TransactionEvent;
use App\Events\UserEvent;
use App\Models\Box;
use App\Models\Car;
use App\Models\Car_Cost;
use App\Models\Deal;
use App\Models\Installment;
use App\Models\Profit;
use App\Models\User;
use Illuminate\Http\Request;
use Monolog\Handler\ElasticaHandler;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Deal::with(['installments'])->get()
        ]);
    }

    public function CashDeal()
    {
        return response()->json([
            'data' => Deal::where('type', 'cash')->get()
        ]);
    }
    public function InstallmentDeal()
    {
        return response()->json([
            'data' => Deal::where('type', 'installments')->get()
        ]);
    }


    public function create_cash_deal(Request $request)
    {

        $request->validate([
            'car_id' => 'required',
            'user_id' => 'required',
        ]);

        $car = Car::find($request->car_id);
        $car_costs = Car_Cost::where('car_id', $request->car_id)->sum('amount');
        $user = User::find($request->user_id);

        // return response()->json(['message' => 'user dont have enough money']);
        $box = Box::first();
        Deal::create([
            'date' => now()->format('Y-m-d'),
            'type' => 'cash',
            'total_cost' => $car->price + $car_costs + (($car->profit->percentage / 100) * $car->price),
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
        ]);
        $car->update(['available' => 0]);
        // BoxEvent::dispatch($box, $request->cash);
        // UserEvent::dispatch($user, -$request->cash);
        // TransactionEvent::dispatch($deal, $box->box_id, $car->car_id);
        return response()->json([
            'message' => 'deal created successfuly',
        ]);
    }

    public function pay_for_cash_deal(Request $request)
    {
        $request->validate([
            'deal_id' => 'required',
        ]);
        $deal = Deal::find($request->deal_id);
        $box = Box::first();
        BoxEvent::dispatch($box, $deal->total_cost);
        TransactionEvent::dispatch($deal, $box->box_id, $deal->car->car_id);
        $deal->update([
            'is_done' => 1
        ]);
        return response()->json([
            'message' => 'deal paid successfuly'
        ]);
    }


    public function create_installment_deal(Request $request)
    {
        $request->validate([
            'car_id' => 'required',
            'user_id' => 'required',
            'installment' => 'required'
        ]);

        $car = Car::find($request->car_id);
        $car_costs = Car_Cost::where('car_id', $request->car_id)->sum('amount');
        $user = User::find($request->user_id);

        if ($request->installment > $user->wallet)
            return response()->json(['message' => 'user dont have enough money']);
        else {
            if ($request->installment > $car->price) {
                return response()->json([
                    'message' => 'error installment value is greater than car price'
                ]);
            } else {
                $box = Box::first();
                $deal =  Deal::create([
                    'date' => now()->format('Y-m-d'),
                    'type' => 'installments',
                    'total_cost' => $car->price + $car_costs + (($car->profit->percentage / 100) * $car->price),
                    'user_id' => $request->user_id,
                    'car_id' => $request->car_id,
                ]);
                $car->update(['available' => 0]);
                Installment::create([
                    'deal_id' => $deal->deal_id,
                    'date' => now()->format('Y-m-d'),
                    'amount' => $request->installment
                ]);
                BoxEvent::dispatch($box, $request->installment);
                UserEvent::dispatch($user, -$request->installment);
                TransactionEvent::dispatch($deal, $box->box_id, $car->car_id);
                return response()->json([
                    'message' => 'deal created successfuly',
                ]);
            }
        }
    }
















    public function show(Deal $deal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deal $deal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        //
    }
}
