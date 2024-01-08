<?php

namespace Modules\Trade\Transformers\Markets;

use Illuminate\Http\Resources\Json\JsonResource;

class MarketTransformer extends JsonResource
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
            'min_amount' => $this->resource->min_amount,
            'max_amount' => $this->resource->max_amount,
            'maker' => $this->resource->maker,
            'taker' => $this->resource->taker,
            'service_base_code' => $this->resource->service_base_code,
            'service_base_id' => $this->resource->service_base_id,
            'service_quote_code' => $this->resource->service_quote_code,
            'service_quote_id' => $this->resource->service_quote_id,
            'service_customer_id' => $this->resource->service_customer_id,
            'status' => (bool) $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.trade.market.destroy', $this->resource->id),
            ],
        ];
    }
}
