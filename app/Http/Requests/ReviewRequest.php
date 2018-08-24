<?php

namespace Ranking\Http\Requests;

class ReviewRequest extends Request
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
        $return = [
            //@todo
        ];
        if ($this->isApi() === false) {
            $return['g-recaptcha-response'] = 'required|recaptcha';
        }
        return $return;
    }
}