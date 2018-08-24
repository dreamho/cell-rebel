<?php

namespace Ranking\Http\Middleware;

use Closure;

class ApiMiddleware
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
        $segment = $request->segment(1);

        if (!is_null($segment) && $segment == "api") {
            $request->merge(['isApi' => true]);
        } else {
            $request->merge(['isApi' => false]);
        }
        
        return $next($request);
    }
}