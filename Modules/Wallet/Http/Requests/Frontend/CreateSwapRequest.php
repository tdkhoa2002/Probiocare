<?php

namespace Modules\Wallet\Http\Requests\Frontend;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateSwapRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'from_currency_id' => 'required',
            'to_currency_id' => 'required',
            'amount_from' => 'required'
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
