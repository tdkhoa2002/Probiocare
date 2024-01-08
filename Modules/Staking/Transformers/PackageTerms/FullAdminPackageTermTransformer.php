<?php

namespace Modules\Staking\Transformers\PackageTerms;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class FullAdminPackageTermTransformer extends JsonResource
{
    public function toArray($request)
    {
        $packageTerm = [
            'id' => $this->resource->id,
            'day_reward' => $this->resource->day_reward,
            'total_stake' => $this->resource->total_stake,
            'type' => $this->resource->type,
            'apr_reward' => $this->resource->apr_reward,
            'created_at' => $this->resource->created_at,
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale) {
            $packageTerm[$locale] = [];
            foreach ($this->resource->translatedAttributes as $translatedAttribute) {
                $packageTerm[$locale][$translatedAttribute] = $this->resource->translateOrNew($locale)->$translatedAttribute;
            }
        }


        return $packageTerm;
    }
}
