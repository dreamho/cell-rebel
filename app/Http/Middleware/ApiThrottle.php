<?php

namespace Ranking\Http\Middleware;

use Illuminate\Support\Facades\Response;
use RuntimeException;
use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;

class ApiThrottle extends ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $maxAttempts
     * @param  int  $decayMinutes
     * @return mixed
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1)
    {
        if ($request->get('isApi')) {
            return parent::handle($request, $next, $maxAttempts, $decayMinutes);
        }

        return $next($request);
    }

    /**
     * Resolve request signature.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     * @throws \RuntimeException
     */
    protected function resolveRequestSignature($request)
    {
        if ($route = $request->route()) {
            return sha1(
                $request->route()->uri().
                '|'.$request->get('mobileClientId')
            );
        }

        throw new RuntimeException('Unable to generate the request signature. Route unavailable.');
    }

    protected function buildResponse($key, $maxAttempts)
    {
        $retryAfter = $this->limiter->availableIn($key);

        header('X-RateLimit-Limit: ' . $maxAttempts);
        header('X-RateLimit-Remaining: ' . $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter));

        if (! is_null($retryAfter)) {
            header('Retry-After: ' . $retryAfter);
        }

        throw new \Exception('Too Many Attempts.');
    }
}