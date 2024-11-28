<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Box::with(['transactions'])->get()
        ]);
    }

    public function add_money_to_box(Request $request)
    {
        try {
            $box = Box::first();
            $request->validate(['value' => 'required']);
            $new_value = $box->value + $request->value;
            $box->update(['value' => $new_value]);
            return response()->json([
                'message' => 'box updated successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'code' => '500',
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Box $box)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Box $box)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Box $box)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Box $box)
    {
        //
    }
}
