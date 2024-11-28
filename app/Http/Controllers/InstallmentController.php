<?php

namespace App\Http\Controllers;

use App\Events\BoxEvent;
use App\Events\TransactionEvent;
use App\Events\UserEvent;
use App\Models\Box;
use App\Models\Deal;
use App\Models\Installment;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Installment::all()
        ]);
    }




    public function store(Request $request)
    {
        $request->validate([
            'deal_id' => 'required',
            'amount' => 'required'
        ]);
        $deal = Deal::withSum('installments as total_installments', 'amount')
            ->where('deal_id', $request->deal_id)
            ->first();

        if ($deal->total_cost < ($deal->total_installments + $request->amount)) {
            return response()->json([
                'message' => 'error total paid is greater than deal value'
            ]);
        } elseif ($deal->total_cost > ($deal->total_installments + $request->amount)) {
            $installment = Installment::create([
                'deal_id' => $request->deal_id,
                'amount' => $request->amount,
                'date' => now()->format('Y-m-d')
            ]);
            $box = Box::first();
            $installment->deal->user; //test
            BoxEvent::dispatch($box, $request->amount);
            UserEvent::dispatch($installment->deal->user, -$request->amount);
            TransactionEvent::dispatch($installment, $box->box_id);
            return response()->json([
                'message' => 'paid successfully'
            ]);
        } else {
            $deal->update(['is_done' => 1]);
            $installment = Installment::create([
                'deal_id' => $request->deal_id,
                'amount' => $request->amount,
                'date' => now()->format('Y-m-d')
            ]);
            $box = Box::first();
            $installment->deal->user; //test
            BoxEvent::dispatch($box, $request->amount);
            UserEvent::dispatch($installment->deal->user, -$request->amount);
            TransactionEvent::dispatch($installment, $box->box_id);
            return response()->json([
                'message' => 'paid successfully , deal is totaly paid'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Installment $installment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Installment $installment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Installment $installment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Installment $installment)
    {
        //
    }
}
