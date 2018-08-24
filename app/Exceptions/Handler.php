<?php

namespace Ranking\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ranking\Models\WorldCountry;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $segment = request()->segment(1);

        if (!is_null($segment) && $segment == "api") {
            die(json_encode(["success" => false, "message" => $e->getMessage()]));
        }

        if ($this->isHttpException($e) && $e->getStatusCode() === 404) {
            $countryCode = 'ph';
            $countries =  WorldCountry::lists('code', 'name')->toArray();

            $data = [
                'countries' => [
                    'data'      => $countries,
                    'default'   => $countryCode
                ]
            ];
            return response()->view('errors.404', $data, 404);
        }

        return parent::render($request, $e);
    }
}
