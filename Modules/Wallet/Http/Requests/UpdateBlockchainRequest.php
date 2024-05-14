<?php

namespace Modules\Wallet\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateBlockchainRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'code' => 'required|unique:wallet__blockchains,code,' . $this->id,
            'title' => 'required',
            'rpc' => 'required',
            'scan' => 'required',
            'native_token' => 'required',
            'type' => 'required',
            'chainid' => 'required',
            'status' => 'required',
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
