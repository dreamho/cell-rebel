<?php

namespace Ranking\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    protected function isApi()
    {
        return $this->segment(1) == 'api';
    }
}
