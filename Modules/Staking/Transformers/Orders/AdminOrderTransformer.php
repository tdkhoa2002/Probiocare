<?php

namespace Modules\Staking\Transformers\Orders;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Customer\Transformers\Customers\SmallCustomerTransformer;
use Modules\Staking\Transformers\PackageTerms\PackageTermTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class AdminOrderTransformer extends JsonResource
{
    public function toArray($request)
    {
        $term = $this->resource->term;
        $package = $term->package;
        $currencyStake = $package->currencyStake ?? null;
        $currencyReward = $package->currencyReward ?? null;
        return [
            'id' => $this->resource->id,
            'code' => $this->resource->code,
            'customer' => new SmallCustomerTransformer($this->resource->customer),
            'packageterm' => new PackageTermTransformer($this->resource->term),
            'currencyStake' => new SmallCurrencyTransformer($currencyStake),
            'currencyReward' => new SmallCurrencyTransformer($currencyReward),
            'amount_stake' => $this->resource->amount_stake,
            'amount_usd_stake' => $this->resource->amount_usd_stake,
            'subscription_date' => $this->resource->subscription_date,
            'redemption_date' => $this->resource->redemption_date,
            'last_time_reward' => $this->resource->last_time_reward,
            'total_amount_reward' => $this->resource->total_amount_reward,
            'amount_reward' => $this->resource->amount_reward,
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at != null ? $this->resource->created_at->format('d-m-Y') : "",
        ];
    }
}
