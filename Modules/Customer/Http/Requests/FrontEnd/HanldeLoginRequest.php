<?php

namespace Modules\Customer\Http\Requests\FrontEnd;

use Modules\Core\Internationalisation\BaseFormRequest;

class HanldeLoginRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'code' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
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
