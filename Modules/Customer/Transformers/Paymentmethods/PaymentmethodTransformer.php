<?php

namespace Modules\Customer\Transformers\Paymentmethods;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentmethodTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $logo = $this->logo();
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'logo' => $logo ? $logo->path_string : "",
            'status' => (bool) $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y H:i:s'),
            'urls' => [
                'delete_url' => route('api.customer.paymentmethod.destroy', $this->resource->id),
            ],
        ];
    }
}
