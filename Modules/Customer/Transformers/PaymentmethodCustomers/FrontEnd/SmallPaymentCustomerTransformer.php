<?php

namespace Modules\Customer\Transformers\PaymentmethodCustomers\FrontEnd;

use Illuminate\Http\Resources\Json\JsonResource;

class SmallPaymentCustomerTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $paymentMethod =  $this->paymentMethod;
        $title = "";
        if ($paymentMethod) {
            $title = $title . $paymentMethod->title;
            $attrs = $paymentMethod->attrs()->where('is_show', true)->get();
            $paymentMethodCustomerAttrs = $this->paymentMethodCustomerAttr;
            foreach ($attrs as $attr) {
                $paymentMethodCustomerAttr = $paymentMethodCustomerAttrs->filter(function ($item) use ($attr) {
                    return $item->payment_attr_id == $attr->id;
                })->first();
                if ($paymentMethodCustomerAttr) {
                    $title = $title . " - " . $paymentMethodCustomerAttr->value;
                }
            }
        }
        return [
            'id' => $this->resource->id,
            'title' =>  $title ?? ""
        ];
    }
}
