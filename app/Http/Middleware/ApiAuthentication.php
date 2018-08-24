<?php

namespace Ranking\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class ApiAuthentication
{
    /**
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * @param \Illuminate\Contracts\Routing\ResponseFactory  $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($request->get('isApi')) {
            try {
                JWTAuth::parseToken();
                $token = JWTAuth::getToken();
            } catch (JWTException $e) {
//                $this->response->json([
//                    'success' => false,
//                    'message' => 'Token missing or badly formatted'
//                ], 401)->send();
                throw new \Exception('Token missing or badly formatted');
            }

            try {
                $mobileClientId = JWTAuth::getPayload($token)->get('sub');
                $request->attributes->add(['mobileClientId' => $mobileClientId]);
            } catch (TokenExpiredException $e) {
//                $this->response->json([
//                    'success' => false,
//                    'message' => 'Token has expired'
//                ], 401)->send();
                throw new \Exception('Token has expired');
            } catch (TokenInvalidException $e) {
//                $this->response->json([
//                    'success' => false,
//                    'message' => 'Token signature not valid'
//                ], 401)->send();
                throw new \Exception('Token signature not valid');
            }
        }

        return $next($request);
    }
}