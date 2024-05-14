<?php

namespace Modules\Wallet\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCurrencyRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'code' => "required|unique:wallet__currencies,code,NULL,id,deleted_at,NULL",
            'title' => "required",
            'type' => "required"
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
