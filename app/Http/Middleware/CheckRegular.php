<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRegular
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
        $role = auth()->user()->role;
        if (!$role == "regular")
            return response()->json("You do not have access to this page", 403);
        return $next($request);
    }
}