<?php

namespace Modules\MarketMaker\Transformers\TargetPrice;

use Illuminate\Http\Resources\Json\JsonResource;

class TargetPriceTransformer extends JsonResource
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
            'symbol' => $this->resource->market->symbol,
            'price' => $this->resource->price,
            'amount' => $this->resource->amount,
            'status' => $this->resource->status,
            'schedule' => $this->resource->schedule,
            'created_at' => $this->resource->created_at,
            'urls' => [
                'delete_url' => route('api.marketmaker.targetprice.delete', $this->resource->id)
            ]
        ];
    }
}
