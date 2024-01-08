<?php

namespace Modules\Peertopeer\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateOrderRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'pay' => 'required',
            'receive' => 'required',
            'adsId' => 'required|exists:peertopeer__ads,id'
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
