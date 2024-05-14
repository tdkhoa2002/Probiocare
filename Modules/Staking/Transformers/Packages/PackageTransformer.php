<?php

namespace Modules\Staking\Transformers\Packages;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Staking\Transformers\PackageTerms\PackageTermTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class PackageTransformer extends JsonResource
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
            'currency_stake_id' => $this->resource->currency_stake_id,
            'currency_stake' => new SmallCurrencyTransformer($this->resource->currencyStake),
            'currency_reward_id' => $this->resource->currency_reward_id,
            'currency_reward' => new SmallCurrencyTransformer($this->resource->currencyReward),
            'terms' => PackageTermTransformer::collection($this->resource->terms),
            'min_stake' => $this->resource->min_stake,
            'max_stake' => $this->resource->max_stake,
            'start_date' => $this->resource->start_date,
            'end_date' => $this->resource->end_date,
            'status' => $this->resource->status,
            'principal_is_stake_currency' => $this->resource->principal_is_stake_currency,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
        ];
    }
}
