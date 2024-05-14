<?php

namespace Modules\Customer\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCustomerRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|unique:customer__customers,email,NULL,id,deleted_at,NULL',
            'password'=>'required',
            'profile.lastname'=>'required',
            'profile.firstname'=>'required',
            'profile.phone_number'=>'required',
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
