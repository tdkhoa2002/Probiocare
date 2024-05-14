<?php

namespace Modules\Staking\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateQuickCommissionRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'floors'=>'required',
            'type'=>'required',
            'commission'=>'required'
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
