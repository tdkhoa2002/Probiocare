<?php

namespace Modules\Customer\Transformers\Customers;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerTransformer extends JsonResource
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
            'profile' => $this->profile,
            'status' => (bool) $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.customer.customer.destroy', $this->resource->id),
            ],
        ];
    }
}
