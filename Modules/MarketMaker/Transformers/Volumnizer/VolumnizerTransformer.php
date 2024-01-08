<?php

namespace Modules\MarketMaker\Transformers\Volumnizer;

use Illuminate\Http\Resources\Json\JsonResource;

class VolumnizerTransformer extends JsonResource
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
            'amount' => $this->resource->amount,
            'time' => $this->resource->interval,
            'start_time' => $this->resource->start_time,
            'interval' => $this->resource->interval,
            'end_time' => $this->resource->end_time,
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at,
            'urls' => [
                'delete_url' => route('api.marketmaker.volumnizer.delete', $this->resource->id)
            ]
        ];
    }
}
