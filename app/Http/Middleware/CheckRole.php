<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User_Role;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // $array = array();
        // $user = $request->user();
        // $roles = User_Role::where('user_id', $user->user_id)->get();

        // foreach ($roles as $r) {
        //     $r1 = Role::where('role_id', $r->role_id)->first();
        //     $array[] = $r1->name;
        // }
        // if (!in_array($role, $array))
        //     return response()->json(['message' => 'Unauthorized'], 403);
        $checked = true;
        $user = $request->user();

        if (! $user || $user->role->name !== $role) {
            $checked = false;
        }
        if ($user->role->name == "manager") {
            $checked = true;
        }


        if (!$checked)
            return response()->json(['message' => 'Unauthorized'], 403);



        return $next($request);
    }
}
