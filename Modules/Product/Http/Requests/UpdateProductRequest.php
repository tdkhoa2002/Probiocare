<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateProductRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'category_id' => 'required',
            'price' => 'required',
            'code' => ['required', Rule::unique('product__products', 'code')->ignore($this->id)],
            'price_sale' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('product__product_translations', 'slug')->ignore($this->id,'product_id')]
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
            'slug.unique' => 'The slug has already been taken.'
        ];
    }
}
