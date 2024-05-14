<?php

namespace Modules\Customer\Http\Requests\FrontEnd;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateKycRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'back_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048',
            ],
            'front_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png',
                'mimetypes:image/jpeg,image/png',
                'max:2048',
            ],
            'selfi_image' => [
                'nullable',
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
