<?php

namespace Modules\Customer\Http\Requests\FrontEnd;

use Modules\Core\Internationalisation\BaseFormRequest;

class VerifyRegisterRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'code' => 'required',
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
