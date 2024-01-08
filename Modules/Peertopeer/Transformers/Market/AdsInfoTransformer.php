<?php

namespace Modules\Peertopeer\Transformers\Market;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Customer\Transformers\PaymentmethodCustomers\FrontEnd\SmallPaymentCustomerTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class AdsInfoTransformer extends JsonResource
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
            "id" => $this->resource->id,
            "ads" => [
                "fiat_currency_id" => $this->resource->fiat_currency_id,
                "asset_currency_id" => $this->resource->asset_currency_id,
                "fixed_price" => $this->resource->fixed_price,
                "total_trade_amount" => $this->resource->total_trade_amount,
                "total_filled" => $this->resource->total_filled,
                "order_limit_min" => $this->resource->order_limit_min,
                "order_limit_max" => $this->resource->order_limit_max,
                "payment_time_limit" => $this->resource->payment_time_limit,
                "type" => $this->resource->type,
                "term" => $this->resource->term,
                "auto_reply" => $this->resource->auto_reply,
                "status" => (bool)$this->resource->status,
                "paymentMethod" => $this->resource->paymentMethods()->pluck('paymentmethod_customers.id')->toArray(),
                "require_kyc" => (bool)$this->resource->require_kyc,
                "require_registered" => (bool) $this->resource->require_registered,
                "require_registered_day" => $this->resource->require_registered_day,
                "require_holding" => (bool) $this->resource->require_holding,
                "require_holding_amount" => $this->resource->require_holding_amount,
            ],
            "fiat_currency"=>new SmallCurrencyTransformer($this->currencyFiat),
            "asset_currency"=>new SmallCurrencyTransformer($this->currency),
            "paymentMethodSelected" => SmallPaymentCustomerTransformer::collection($this->resource->paymentMethods),

        ];
    }
}
