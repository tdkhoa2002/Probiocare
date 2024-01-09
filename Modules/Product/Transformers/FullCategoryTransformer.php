<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullCategoryTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $categoryData = [
            'id' => $this->resource->id,
            'parent_id' => $this->resource->parent_id,
            'status' => (bool) $this->resource->status,
            'show_homepage' => (bool) $this->resource->show_homepage,
            'show_menu' => (bool) $this->resource->show_menu,
            'show_sidebar' => (bool) $this->resource->show_sidebar,
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
            $categoryData[$locale] = [];
            foreach ($this->resource->translatedAttributes as $translatedAttribute) {
                $categoryData[$locale][$translatedAttribute] = $this->resource->translateOrNew($locale)->$translatedAttribute;
            }
        }
        return $categoryData;
    }
}
