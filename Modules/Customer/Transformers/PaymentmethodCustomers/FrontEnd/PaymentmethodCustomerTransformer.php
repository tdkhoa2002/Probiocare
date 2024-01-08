<?php

namespace Modules\Customer\Transformers\PaymentmethodCustomers\FrontEnd;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Customer\Transformers\PaymentMethodCustomerAttrs\FrontEnd\PaymentMethodCustomerAttrTransformer;
use Modules\Customer\Transformers\Paymentmethods\FrontEnd\PaymentmethodTransformer;

class PaymentmethodCustomerTransformer extends JsonResource
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
            'paymentMethod' => new PaymentmethodTransformer($this->paymentMethod),
            'paymentMethodCustomerAttr' => PaymentMethodCustomerAttrTransformer::collection($this->paymentMethodCustomerAttr),
            'created_at' => $this->resource->created_at->format('d-m-Y H:i:s')
        ];
    }
}
