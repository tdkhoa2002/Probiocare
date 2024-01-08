<?php

namespace Modules\Peertopeer\Transformers\Market;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Customer\Transformers\Customers\SmallCustomerTransformer;
use Modules\Customer\Transformers\PaymentmethodCustomers\FrontEnd\PaymentmethodCustomerTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class FullOrderInfoTransformer extends JsonResource
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
            "seller" => new SmallCustomerTransformer($this->resource->seller),
            "fixed_price" => $this->resource->fixed_price,
            "total_fiat_amount" => $this->resource->total_fiat_amount,
            "paymentmethod_id" => $this->resource->paymentmethod_id,
            "paymentmethod" => new PaymentmethodCustomerTransformer( $this->resource->paymentMethod),
            "total_asset_amount" => $this->resource->total_asset_amount,
            "total_receive_amount" => $this->resource->total_receive_amount,
            "room_id" => $this->resource->room_id,
            "code" => $this->resource->code,
            "fiat_currency" => new SmallCurrencyTransformer($this->resource->fiatCurrency),
            "asset_currency" => new SmallCurrencyTransformer($this->resource->assetCurrency),
            "ad" => [
                'customer' => new SmallCustomerTransformer($this->resource->ad->customer),
                "fiat_currency" => new SmallCurrencyTransformer($this->resource->ad->currencyFiat),
                "asset_currency" => new SmallCurrencyTransformer($this->resource->ad->currency),
            ],
            "type" => $this->resource->type,
            "status" => $this->resource->status,
            "status_string" => $this->handleStatus($this->resource->status),
            "url" => [
                "get_order" => route('fe.p2p.order.detail', $this->resource->id),
                "cancel_order" => route('fe.p2p.order.create', $this->resource->id),
                "agent_url" => route('fe.p2p.market.byagent', $this->resource->ad->customer->id),

            ],
            'ads' => new SmallAdsInfoTransformer($this->resource->ad),
            "created_at" => $this->resource->created_at,
            "updated_at" => $this->resource->updated_at,
            "deleted_at" => $this->resource->deleted_at,
        ];
    }

    private function handleStatus($status)
    {
        switch ($status) {
            case 0:
                return "Payment Pending";
                break;
            case 1:
                return "Payment Transfered";
                break;
            case 2:
                return "Completed";
                break;
            case 3:
                return "Cancelled";
                break;
            case 4:
                return "Cancelled Timeout";
                break;
        }
    }
}
