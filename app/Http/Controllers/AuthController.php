<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Manager;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function user_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::IS_USER
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'role_id' => Role::IS_USER,
            'token_type' => 'Bearer',
        ]);
    }

    public function manager_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:managers',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $manager = Manager::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::IS_ADMIN
        ]);

        $token = $manager->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function login(Request $request)
    {
        $manager = Manager::where('email', $request->email)->first();
        if ($manager) {
            if (Hash::check($request->password, $manager->password)) {
                $token =  $manager->createToken('auth_token')->plainTextToken;
                $manager->token = $token;
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'message' => 'hello manager',
                ]);
            }
        } else if ($user = User::where('email', $request->email)->first()) {
            if (Hash::check($request->password, $user->password)) {
                $token =  $user->createToken('auth_token')->plainTextToken;
                $user->token = $token;
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'message' => 'hello user'
                ]);
            }
        } elseif ($employee = Employee::where('email', $request->email)->first()) {
            if (Hash::check($request->password, $employee->password)) {
                $token =  $employee->createToken('auth_token')->plainTextToken;
                $employee->token = $token;
                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'message' => 'hello employee'
                ]);
            }
        } else
            return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
