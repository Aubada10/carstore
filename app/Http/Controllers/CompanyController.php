<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Company::all()
        ]);
    }

    public function Mcopmanies()
    {

        return response()->json([
            'data' => Company::where('type', 'maintenance')->get()
        ]);
    }
    public function Tcopmanies()
    {

        return response()->json([
            'data' => Company::where('type', 'transport')->get()
        ]);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:120'],
            'contact_details' => ['required'],
            'type' => ['required', Rule::in(['maintenance', 'transport'])]
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $company = Company::create([
            'name' => $request->name,
            'contact_details' => $request->contact_details,
            'type' => $request->type
        ]);

        return response()->json([
            'data' => $company,
            'message' => 'added successfully'
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show($company_id)
    {
        return response()->json([
            'data' => Company::with(['car_costs'])->where('company_id', $company_id)->first()
        ]);
    }


    public function update(Request $request)
    {
        $company = Company::where('company_id', $request->company_id)->first();
        $company->update($request->all());
        return response()->json([
            'data' => $company,
            'message' => 'updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $company = Company::where('company_id', $request->company_id)->first();
        $company->delete();
        return response()->json([
            'message' => 'deleted_successfully'
        ]);
    }
}
