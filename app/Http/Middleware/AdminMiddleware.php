<?php

namespace Ranking\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{

    /**
     * Handle an incoming request. User must be logged in to do admin check
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
        if (Auth::guard($guard)->guest()) 
        {
            if ($request->ajax()) 
            {
                return response('Unauthorized.', 401);
            } else 
            {
                return redirect()->guest('login');
            }
        }
        
        if (Auth::user()->is_admin == 1)
        {
            return $next($request);
        }

        return redirect()->guest('/');
    }
}