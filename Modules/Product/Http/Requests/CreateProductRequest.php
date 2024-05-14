<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Internationalisation\BaseFormRequest;

class CreateProductRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'category_id'=>'required',
            'price'=>'required',
            'code'=>['required', Rule::unique('product__products', 'code')],
            'price_sale'=>'required',
        ];
    }

    public function translationRules()
    {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('product__product_translations', 'slug')],
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'code.unique'=>'The code has already been taken.'
        ];
    }

    public function translationMessages()
    {
        return [
            'slug.unique'=>'The slug has already been taken.'
        ];
    }
}
