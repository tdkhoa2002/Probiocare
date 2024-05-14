<?php

namespace Modules\Wallet\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCurrencyAttrRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'blockchain_id' => 'required',
          //  'token_address' => "required|unique:wallet__currencyattrs,token_address,NULL,id,deleted_at,NULL",
            'decimal' => 'required',
            'type_withdraw' => 'required',
            'type_deposit' => 'required',
            'type_transfer' => 'required',
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
