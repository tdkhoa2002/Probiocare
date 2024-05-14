<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullProductTransformer extends JsonResource
{
    public function toArray($request)
    {
        $product = [
            'id' => $this->resource->id,
            'status' => (bool) $this->resource->status,
            'show_homepage' => (bool) $this->resource->show_homepage,
            'is_best_choice' => (bool) $this->resource->is_best_choice,
            'is_best_selling' => (bool) $this->resource->is_best_selling,
            'is_new_arrivals' => (bool) $this->resource->is_new_arrivals,
            'price' => $this->resource->price,
            'product_status' => $this->resource->product_status,
            'code' => $this->resource->code,
            'total_sold' => $this->resource->total_sold,
            'price_member' => $this->resource->price_member,
            'price_sale' => $this->resource->price_sale,
            'category_id' => $this->resource->category_id
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
            $product[$locale] = [];
            foreach ($this->resource->translatedAttributes as $translatedAttribute) {
                $product[$locale][$translatedAttribute] = $this->resource->translateOrNew($locale)->$translatedAttribute;
            }
        }
        return $product;
    }
}
