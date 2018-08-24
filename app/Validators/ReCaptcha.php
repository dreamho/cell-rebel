<?php
namespace Ranking\Validators;

use GuzzleHttp\Client;

class ReCaptcha
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $client = new Client();

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify',
            ['form_params'=>
                [
                    'secret'    => env('GOOGLE_RECAPTCHA_V2_SECRET_KEY'),
                    'response'  => $value,
                    'remoteip'  => $_SERVER['REMOTE_ADDR'],
                ]
            ]
        );

        $body = json_decode((string)$response->getBody());

        return $body->success;
    }
}