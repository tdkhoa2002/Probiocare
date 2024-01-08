<?php

namespace Modules\Trade\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateMarketRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            "symbol" => "required|unique:trade__markets,symbol,NULL,id,deleted_at,NULL",
            "currency_id" => "required",
            "currency_pair_id" => "required",
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
