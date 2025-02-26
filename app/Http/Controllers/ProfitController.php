<?php

namespace App\Http\Controllers;

use App\Models\Profit;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Profit::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profit $profit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profit $profit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profit $profit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profit $profit)
    {
        //
    }
}
