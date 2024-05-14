<?php

namespace Modules\Staking\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdatePackageRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'currency_stake_id' => 'required',
            'currency_reward_id' => 'required',
            'min_stake'=>'required|integer',
            'max_stake'=>'required|integer|gt:min_stake',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
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
