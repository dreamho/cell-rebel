<?php

namespace Ranking\Http\Requests;

class ContactRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'g-recaptcha-response'  => 'required|recaptcha',
            'name'                 => 'required',
            'email'                 => 'required|email',
            'message'               => 'required',
        ];
    }
}