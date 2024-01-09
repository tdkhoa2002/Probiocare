<?php

namespace Modules\ShoppingCart\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Product\Transformers\ProductOrderTransformer;

class OrderDetailTransformer extends JsonResource
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
            'order_id ' => $this->resource->order_id,
            'product_id' =>  $this->resource->product_id,
            'price' =>  $this->resource->price,
            'qty' =>  $this->resource->qty,
            'total' =>  $this->resource->total,
            'note' =>  $this->resource->note,
            'total' =>  $this->resource->total,
            'product' => new ProductOrderTransformer($this->resource->product)
        ];
    }
}
