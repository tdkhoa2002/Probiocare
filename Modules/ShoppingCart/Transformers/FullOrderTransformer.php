<?php

namespace Modules\ShoppingCart\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullOrderTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $orderData = [
            'id' => $this->resource->id,
            'order_code' => $this->resource->order_code,
            'fullname' =>  $this->resource->fullname,
            'email' =>  $this->resource->email,
            'phone_number' =>  $this->resource->phone_number,
            'address' =>  $this->resource->address,
            'note' =>  $this->resource->note,
            'total' =>  $this->resource->total,
            'payment_method' =>  $this->resource->payment_method,
            'delivery_method' =>  $this->resource->delivery_method,
            'payment_code' =>  $this->resource->payment_code,
            'time_ship' =>  $this->resource->time_ship,
            'status' =>  $this->resource->status,
            'created_at' =>  $this->resource->created_at,
            'orderDetails' => OrderDetailTransformer::collection($this->resource->orderDetails)
        ];

        return $orderData;
    }
}
