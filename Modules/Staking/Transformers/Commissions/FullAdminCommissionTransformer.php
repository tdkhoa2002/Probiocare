<?php

namespace Modules\Staking\Transformers\Commissions;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullAdminCommissionTransformer extends JsonResource
{
    public function toArray($request)
    {
        $commission = [
            'id' => $this->resource->id,
            'level' => $this->resource->level,
            'commission' => $this->resource->commission,
            'type' => $this->resource->type,
            'status' => (bool) $this->resource->status
        ];

        return $commission;
    }
}
