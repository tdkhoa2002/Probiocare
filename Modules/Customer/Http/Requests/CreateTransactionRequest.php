<?php

namespace Modules\Customer\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateTransactionRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'currency_id' => 'required',
            'action' => 'required',
            'amount' => 'required',
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
