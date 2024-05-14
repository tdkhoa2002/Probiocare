<?php

namespace Modules\Customer\Transformers\Customers;

use Illuminate\Http\Resources\Json\JsonResource;

class SmallCustomerTransformer extends JsonResource
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
            'full_name'=> $this->resource->profile->firstname . " " . $this->resource->profile->lastname
        ];
    }
}
