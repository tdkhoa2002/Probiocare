<?php

namespace Modules\Customer\Http\Requests\FrontEnd;

use Modules\Core\Internationalisation\BaseFormRequest;

class RequestKycRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'back_image' => [
                'required',
                'image',
                'mimes:jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048',
            ],
            'front_image' => [
                'required',
                'image',
                'mimes:jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048',
            ],
            'selfi_image' => [
                'required',
                'image',
                'mimes:jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048',
            ],
            'id_number' => 'required',
            'id_type' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'birthday' => 'required',
            'country_id' => 'required',
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
