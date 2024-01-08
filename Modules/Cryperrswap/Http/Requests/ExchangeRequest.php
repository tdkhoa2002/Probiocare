<?php

namespace Modules\Cryperrswap\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class ExchangeRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'fromCcy' => 'required',
            'toCcy' => 'required',
            'amount' => 'required',
            'direction' => 'required',
            'type' => 'required',
            'toAddress' => 'required'
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
