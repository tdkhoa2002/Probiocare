<?php

namespace Modules\Cryperrswap\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CalExchangeRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'type' => 'required',
            'fromCcy' => 'required',
            'toCcy' => 'required',
            'toAmount' => 'required',
            'direction' => 'required'
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
