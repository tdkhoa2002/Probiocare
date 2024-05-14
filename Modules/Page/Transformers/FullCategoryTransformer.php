<?php

namespace Modules\Page\Transformers;

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
            'status' => (bool) $this->resource->status,
            'parent_id' => $this->resource->parent_id,
            'show_homepage' => (bool) $this->resource->show_homepage,
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
