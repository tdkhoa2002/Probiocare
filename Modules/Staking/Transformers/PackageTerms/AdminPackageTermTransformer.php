<?php

namespace Modules\Staking\Transformers\PackageTerms;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class AdminPackageTermTransformer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'day_reward' => $this->resource->day_reward,
            'total_stake' => $this->resource->total_stake,
            'type' => $this->resource->type,
            'title' => $this->resource->title,
            'apr_reward' => $this->resource->apr_reward,
            'created_at' => $this->resource->created_at->format('d-m-Y') ?? "",
            'urls' => [
                'delete_url' => route('api.staking.packageTerm.destroy', $this->resource->id),
            ],
        ];
    }
}
