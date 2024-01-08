<?php

namespace Modules\Cryperrswap\Transformers\Services;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullServiceTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $service = [
            'id' => $this->resource->id,
            'status' => (bool) $this->resource->status,
            'code' => $this->resource->code,
            'api_key' => $this->resource->api_key,
            'serect_key' => $this->resource->serect_key,
            'refcode' => $this->resource->refcode,
            'afftax' => $this->resource->afftax
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
            $service[$locale] = [];
            foreach ($this->resource->translatedAttributes as $translatedAttribute) {
                $service[$locale][$translatedAttribute] = $this->resource->translateOrNew($locale)->$translatedAttribute;
            }
        }
        return $service;
    }
}
