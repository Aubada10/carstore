<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Supplier::with(['cars'])->get()
        ]);
    }


    public function store(Request $request)
    {

        //error warning employee id
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:120'],
            'contact' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($request->user() instanceof Employee) {
            $supplier = Supplier::create([
                'name' => $request->name,
                'contact' => $request->contact,
                'employee_id' => $request->user()->employee_id
            ]);
            return response()->json([
                'data' => $supplier,
                'message' => 'added successfully'
            ]);
        } else {
            $supplier = Supplier::create([
                'name' => $request->name,
                'contact' => $request->contact,

            ]);
            return response()->json([
                'data' => $supplier,
                'message' => 'added successfully'
            ]);
        }
    }


    public function show(Request $request)
    {
        return response()->json([
            'data' => Supplier::where('supplier_id', $request->supplier_id)->first()
        ]);
    }


    public function update(Request $request)
    {
        $supplier = Supplier::where('supplier_id', $request->supplier_id)->first();

        $supplier->update($request->all());
        return response()->json([
            'data' => $supplier,
            'message' => 'updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $supplier = Supplier::where('supplier_id', $request->supplier_id)->first();
        $supplier->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
