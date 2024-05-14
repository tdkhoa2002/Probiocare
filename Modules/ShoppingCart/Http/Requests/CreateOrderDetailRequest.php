<?php

namespace Modules\ShoppingCart\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateOrderDetailRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
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
