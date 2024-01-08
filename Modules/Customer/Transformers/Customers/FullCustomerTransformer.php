<?php

namespace Modules\Customer\Transformers\Customers;

use Illuminate\Http\Resources\Json\JsonResource;

class FullCustomerTransformer extends JsonResource
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
            'email' => $this->resource->email,
            'ref_code' => $this->resource->ref_code,
            'sponsor_floor' => $this->resource->sponsor_floor,
            'sponsor_id' => $this->resource->sponsor_id,
            'profile' => $this->resource->profile,
            'status' => (bool) $this->resource->status
        ];
    }
}
