<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {

        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('product__category_translations', 'slug')],
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
        return [
            'slug.unique'=>'The slug has already been taken.'
        ];
    }
}
