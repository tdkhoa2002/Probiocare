<?php

namespace Modules\Customer\Http\Requests\FrontEnd;

use Modules\Core\Internationalisation\BaseFormRequest;

class ResendVerifyRegisterRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email'
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
