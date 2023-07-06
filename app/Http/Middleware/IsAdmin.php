<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class IsAdmin
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
		if (Auth::user()->role == 'admin') {
            return $next($request);
        }
		if(Auth::user()){
			Auth::logout();
		}
        return redirect()->route('login')->with('error', 'Only Admin Can Access.'); // If user is not an admin.
    }
}
