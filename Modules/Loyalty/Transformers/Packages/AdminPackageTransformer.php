<?php

namespace Modules\Loyalty\Transformers\Packages;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class AdminPackageTransformer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'icon' => $this->resource->getIcon()->path_string ?? "",
            'currency_stake_id' => $this->resource->currency_stake_id,
            'currency_stake' => new SmallCurrencyTransformer($this->resource->currencyStake),
            'currency_reward_id' => $this->resource->currency_reward_id,
            'currency_reward' => new SmallCurrencyTransformer($this->resource->currencyReward),
            'currency_cashback_id' => $this->resource->currency_cashback_id,
            'currency_cashback' => new SmallCurrencyTransformer($this->resource->currencyCashback),
            'min_stake' => $this->resource->min_stake,
            'max_stake' => $this->resource->max_stake,
            'start_date' => Carbon::parse($this->resource->start_date)->format('d-m-Y') ?? "",
            'end_date' => Carbon::parse($this->resource->end_date)->format('d-m-Y') ?? "",
            'principal_is_stake_currency' => (bool) $this->resource->principal_is_stake_currency,
            'require_entry' => (bool) $this->resource->require_entry,
            'status' => (bool) $this->resource->status,
            'principal_convert_rate' => $this->resource->principal_convert_rate,
            'term_matching' => $this->resource->term_matching,
            'translations' => [
                'title' => optional($this->resource->translate(locale()))->title,
            ],
            'created_at' => $this->resource->created_at != null ? $this->resource->created_at->format('d-m-Y') : "",
            'urls' => [
                'delete_url' => route('api.loyalty.package.destroy', $this->resource->id),
            ],
        ];
    }
}
