<?php

namespace Modules\Trade\Transformers\Markets;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullMarketTransformer extends JsonResource
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
            'symbol' => $this->resource->symbol,
            'currency_id' => $this->resource->currency_id,
            'currency_pair_id' => $this->resource->currency_pair_id,
            'type' => $this->resource->type,
            'taker' => $this->resource->taker,
            'maker' => $this->resource->maker,
            'min_amount' => $this->resource->min_amount,
            'max_amount' => $this->resource->max_amount,
            'price_usd' => $this->resource->price_usd,
            'status' => (bool) $this->resource->status,
        ];
    }
}
