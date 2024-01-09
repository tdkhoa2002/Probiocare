<?php

namespace Modules\Loyalty\Transformers\Packages;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AdminPackageTransformer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'reward' => $this->resource->reward,
            'cashback' => $this->resource->cashback,
            'day_reward' => $this->resource->day_reward,
            'term_matching' => $this->resource->term_matching,
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at != null ? $this->resource->created_at->format('d-m-Y') : "",
            'urls' => [
                'delete_url' => route('api.loyalty.package.destroy', $this->resource->id),
            ],
        ];
    }
}
