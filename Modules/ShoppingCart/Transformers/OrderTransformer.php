<?php

namespace Modules\ShoppingCart\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderTransformer extends JsonResource
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
            'order_code' => $this->resource->order_code,
            'fullname' =>  $this->resource->fullname,
            'email' =>  $this->resource->email,
            'phone_number' =>  $this->resource->phone_number,
            'address' =>  $this->resource->address,
            'note' =>  $this->resource->note,
            'total' =>  $this->resource->total,
            'delivery_method' =>  $this->resource->delivery_method,
            'payment_method' =>  $this->resource->payment_method,
            'time_ship' =>  $this->resource->time_ship,
            'status' =>  $this->resource->status,
            'created_at' =>  $this->resource->created_at,
            'urls' => [
                'delete_url' => route('api.shoppingcart.order.destroy', $this->resource->id),
            ],
        ];
    }
}
