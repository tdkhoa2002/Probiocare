<?php

namespace Modules\Wallet\Transformers\Wallets;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Customer\Transformers\Customers\SmallCustomerTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class WalletTransformer extends JsonResource
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
            'customer_id' => $this->resource->customer_id,
            'currency_id' => $this->resource->currency_id,
            'walletChains' => WalletChainTransformer::collection($this->walletChains),
            'currency' => new SmallCurrencyTransformer($this->currency),
            'customer' => new SmallCustomerTransformer($this->customer),
            'type' => $this->resource->type,
            'balance' => $this->resource->balance,
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y H:i:s'),
        ];
    }
}
