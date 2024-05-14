<?php

namespace Modules\Staking\Transformers\Commissions;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminCommissionTransformer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'level' => $this->resource->level,
            'commission' => $this->resource->commission,
            'type' => $this->resource->type,
            'status' => (bool) $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y') ?? "",
            'urls' => [
                'delete_url' => route('api.staking.commission.destroy', $this->resource->id),
            ],
        ];
    }
}
