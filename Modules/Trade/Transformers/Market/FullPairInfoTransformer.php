<?php

namespace Modules\Trade\Transformers\Market;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullPairInfoTransformer extends JsonResource
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
            'symbol' => $this->resource->symbol,
            'base' => [
                'symbol' => $this->resource->currency->code,
                'title' => $this->resource->currency->title,
                'priceUSD' => $this->resource->currency->usd_rate,
            ],
            'quote' => [
                'symbol' => $this->resource->currencyPair->code,
                'title' => $this->resource->currencyPair->title,
                'priceUSD' => $this->resource->currencyPair->usd_rate,
            ],
            'price' => $this->resource->price,
            'priceChange24h' => $this->resource->price_change_24h,
            'hight24h' => $this->resource->hight_24h,
            'low24h' => $this->resource->low_24h,
            'volume24h' => $this->resource->volume_24h,
            'volumePair24h' => $this->resource->volume_pair_24h,
            'updatedAt' => $this->resource->updated_at,
        ];
    }
}
