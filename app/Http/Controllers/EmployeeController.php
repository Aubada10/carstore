<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Role;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Empty_;

class EmployeeController extends Controller

{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Employee::all()
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::IS_EMPLOYEE,
            'manager_id' => $request->user()->manager_id
        ]);

        return response()->json([
            'data' => $employee,
            'message' => 'added successfully'
        ]);
    }



    public function show(Employee $employee)
    {

        return response()->json([
            'data' => $employee
        ]);
    }

    public function update(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        $employee->update($request->all());
        return response()->json([
            'message' => 'updated successfully'
        ]);
    }


    public function destroy(Request $request)
    {
        $employee = Employee::find($request->employee_id);
        $employee->delete();
        return response()->json([
            'message' => 'deleted successfully'
        ]);
    }
}
