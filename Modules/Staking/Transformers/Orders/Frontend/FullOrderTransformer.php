<?php

namespace Modules\Staking\Transformers\Orders\Frontend;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Customer\Transformers\Customers\SmallCustomerTransformer;
use Modules\Staking\Transformers\PackageTerms\PackageTermTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class FullOrderTransformer extends JsonResource
{
    public function toArray($request)
    {
        $principal = "";
        $term = $this->resource->term;
        $package = $term->package;
        if ($package) {
            $currencyStake = $package->currencyStake;
            $currencyReward = $package->currencyReward;
            if ($package->principal_is_stake_currency == true) {
                $principal = $this->amount_stake . " " . ($currencyStake ? $currencyStake->code : "");
            } else {
                $principal = $this->amount_reward . " " . ($currencyReward ? $currencyReward->code : "");
            }
            $amount_reward = $this->resource->amount_reward;
            $total_amount_reward = $this->resource->total_amount_reward;
        }else{
            $principal = "N/A"; // package has been removed
            $amount_reward = "N/A"; // package has been removed
            $total_amount_reward = "N/A"; // package has been removed
            $currencyStake = null;
            $currencyReward = null;
        }

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
            'total_amount_reward' => $total_amount_reward,
            'amount_reward' => $amount_reward,
            'principal' => $principal,
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at
        ];
    }
}