<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class VendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $guard = 'user')
    {

        if (!Auth::guard($guard)->check()) {
            return redirect('/');
        }
        
        $user = Auth::guard($guard)->user();

        // Check the user_type property
        if ($user && $user->user_type != 2) {
            return redirect('/');
        }
    

		return $next($request);
    }
}
