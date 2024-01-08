<?php

namespace Modules\Peertopeer\Transformers\Market;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Customer\Transformers\Customers\SmallCustomerTransformer;
use Modules\Customer\Transformers\PaymentmethodCustomers\FrontEnd\PaymentmethodCustomerTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class FullAdsInfoTransformer extends JsonResource
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
            "customer" => new SmallCustomerTransformer($this->resource->customer),
            "fiat_currency" => new SmallCurrencyTransformer($this->resource->currencyFiat),
            "asset_currency" => new SmallCurrencyTransformer($this->resource->currency),
            "fixed_price" => $this->resource->fixed_price,
            "total_trade_amount" => $this->resource->total_trade_amount,
            "total_filled" => $this->resource->total_filled,
            "order_limit_min" => $this->resource->order_limit_min,
            "order_limit_max" => $this->resource->order_limit_max,
            "payment_time_limit" => $this->resource->payment_time_limit,
            "paymentMethods" => PaymentmethodCustomerTransformer::collection($this->resource->paymentMethods),
            "type" => $this->resource->type,
            "term" => $this->resource->term,
            "auto_reply" => $this->resource->auto_reply,
            "status" => $this->resource->status,
            "url" => [
                "agent_url" => route('fe.p2p.market.byagent', $this->resource->customer->id),
                "create_order" => route('fe.p2p.order.create', $this->resource->id),
                "edit_ads" => route('fe.p2p.ads.edit', $this->resource->id),
            ],
            "created_at" => $this->resource->created_at,
            "updated_at" => $this->resource->updated_at,
            "deleted_at" => $this->resource->deleted_at,
        ];
    }
}
