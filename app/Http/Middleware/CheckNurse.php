<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckNurse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // get role of auth user
        $role = auth()->user()->role;

        if ($role !== "nurse")
            return response()->json("You do not have access to this page", 403);
        return $next($request);
    }
}
