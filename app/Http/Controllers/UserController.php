<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }


    public function add_money_to_wallet(Request $request)
    {
        $user = User::find($request->user_id);
        $value = $user->wallet + $request->value;
        $user->update([
            'wallet' => $value
        ]);
        return response()->json([
            'message' => 'money added successfully'
        ]);
    }













    public function store(Request $request)
    {
        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }

    public function BlockUser(Request $request)
    {
        $user = User::find($request->id);
        $user->update(['role_id' => Role::BLOCKED]);
        return response()->json([
            'message' => 'user blocked',
            'data' => $user
        ]);
    }
}
