<?php

namespace Modules\Peertopeer\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateAdsRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'fiat_currency_id' => 'required|exists:wallet__currencies,id',
            'asset_currency_id' => 'required|exists:wallet__currencies,id',
            'fixed_price' => 'required',
            'total_trade_amount' => 'required',
            'order_limit_min' => 'required',
            'order_limit_max' => 'required',
            'payment_time_limit' => 'required',
            'type' => 'required'
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
