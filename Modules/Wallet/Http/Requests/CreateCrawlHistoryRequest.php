<?php

namespace Modules\Wallet\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCrawlHistoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            "blockchain_id" => "required",
            "currency_id" => "required",
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
