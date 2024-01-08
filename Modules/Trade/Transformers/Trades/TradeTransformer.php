<?php

namespace Modules\Trade\Transformers\Trades;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Customer\Transformers\Customers\SmallCustomerTransformer;
use Modules\Trade\Transformers\Markets\FullMarketTransformer;

class TradeTransformer extends JsonResource
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
            'customer_id'=> $this->resource->customer_id,
            'customer'=>new SmallCustomerTransformer($this->customer),
            'market_id'=> $this->resource->market_id,
            'market'=> new FullMarketTransformer($this->market),
            'amount'=> $this->resource->amount,
            'price_was'=> $this->resource->price_was,
            'total_fee'=> $this->resource->total_fee,
            'fee'=> $this->resource->fee,
            'fill'=> $this->resource->fill,
            'trade_type'=> $this->resource->trade_type,
            'status'=> $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y H:i:s')
        ];
    }
}