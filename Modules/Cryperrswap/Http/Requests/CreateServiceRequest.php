<?php

namespace Modules\Cryperrswap\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateServiceRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'code' => 'required',
            'api_key' => 'required',
            'serect_key' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
            'title' => 'required'
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

    public function translationMessages()
    {
        return [];
    }
}
