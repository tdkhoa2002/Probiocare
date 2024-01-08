<?php

namespace Modules\Wallet\Transformers\Currencies;

use Illuminate\Http\Resources\Json\JsonResource;

class SmallCurrencyTransformer extends JsonResource
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
            'code' => $this->resource->code,
            'title' => $this->resource->title,
            'status' => (bool) $this->resource->status,
        ];
    }
}
