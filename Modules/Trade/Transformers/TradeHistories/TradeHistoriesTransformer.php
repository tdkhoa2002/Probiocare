<?php

namespace Modules\Trade\Transformers\TradeHistories;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TradeHistoriesTransformer extends JsonResource
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
            'amount'=> $this->resource->amount,
            'fee'=> $this->resource->fee,
            'fill'=> $this->resource->fill,
            'is_maker'=> $this->resource->is_maker,
            'price'=> $this->resource->price,
            'trade_type'=> $this->resource->trade_type,
            'created_at' => Carbon::parse($this->resource->created_at)->toDateTimeString()
        ];
    }
}