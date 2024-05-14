<?php

namespace Modules\Customer\Transformers\Paymentmethods\FrontEnd;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Customer\Transformers\PaymentmethodAttrs\FrontEnd\PaymentmethodAttrTransformer;

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
            'attrs'=> PaymentmethodAttrTransformer::collection($this->attrs)
        ];
    }
}
