<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Exchange::all()
        ]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'price' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $exchange = Exchange::create([
            'price' => $request->price,
            'date' => now()->format('Y-m-d'),
            'manager_id' => $request->user()->manager_id
        ]);

        return response()->json([
            'data' => $exchange,
            'message' => 'added successfuly'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($exchange_id)
    {
        return response()->json([
            'data' => Exchange::where('exchange_id', $exchange_id)->first()
        ]);
    }



    public function update(Request $request)
    {
        $exchange = Exchange::where('exchange_id', $request->exchange_id)->first();
        $exchange->update($request->all());
        return response()->json([
            'data' => $exchange,
            'message' => 'updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $exchange = Exchange::where('exchange_id', $request->exchange_id)->first();
        $exchange->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
