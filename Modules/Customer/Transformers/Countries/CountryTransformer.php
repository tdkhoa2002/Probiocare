<?php

namespace Modules\Customer\Transformers\Countries;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'code' => $this->resource->country_code, 
            'name' => $this->resource->country_name,
        ];
    }
}
