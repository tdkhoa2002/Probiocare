<?php

namespace Modules\Customer\Http\Requests\FrontEnd;

use Modules\Core\Internationalisation\BaseFormRequest;

class RegisterRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|unique:customer__customers,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'firstname' => 'required',
            'lastname' => 'required',
            'signup_agree' => 'required',
            'country_id' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

}
