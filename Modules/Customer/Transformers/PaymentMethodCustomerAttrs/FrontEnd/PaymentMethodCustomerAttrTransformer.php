<?php
namespace Modules\Customer\Transformers\PaymentMethodCustomerAttrs\FrontEnd;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodCustomerAttrTransformer extends JsonResource
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
            'payment_attr_id' => $this->resource->payment_attr_id,
            'value' => $this->resource->value,
        ];
    }
}
