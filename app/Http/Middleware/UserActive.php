<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() &&  Auth::user()->active == 0) {
            return response()->json([
                'responseMessage' => 'You do not have   Access.',
            ],Response::HTTP_UNAUTHORIZED);
        } else  if (Auth::user() &&  Auth::user()->active == 1) {
            return $next($request);
        }
    }
}
