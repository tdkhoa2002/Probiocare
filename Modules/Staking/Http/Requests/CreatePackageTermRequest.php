<?php

namespace Modules\Staking\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreatePackageTermRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'day_reward' => 'required',
            'total_stake' => 'required',
            'type' => 'required',
            'apr_reward' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
            'title' => 'required',
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
