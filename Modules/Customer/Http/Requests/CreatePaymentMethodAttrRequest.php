<?php

namespace Modules\Customer\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreatePaymentMethodAttrRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {
        return ['title'=>'required'];
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
