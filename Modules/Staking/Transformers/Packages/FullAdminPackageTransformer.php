<?php

namespace Modules\Staking\Transformers\Packages;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class FullAdminPackageTransformer extends JsonResource
{
    public function toArray($request)
    {
        $package = [
            'id' => $this->resource->id,
            'currency_stake_id' => $this->resource->currency_stake_id,
            'currency_reward_id' => $this->resource->currency_reward_id,
            'min_stake' => $this->resource->min_stake,
            'max_stake' => $this->resource->max_stake,
            'start_date' => $this->resource->start_date,
            'hour_reward' => $this->resource->hour_reward,
            'end_date' => $this->resource->end_date,
            'status' => (bool) $this->resource->status,
            'principal_is_stake_currency' => (bool) $this->resource->principal_is_stake_currency,
            'created_at' => $this->resource->created_at,
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
            $package[$locale] = [];
            foreach ($this->resource->translatedAttributes as $translatedAttribute) {
                $package[$locale][$translatedAttribute] = $this->resource->translateOrNew($locale)->$translatedAttribute;
            }
        }


        return $package;
    }
}
