<?php

namespace Modules\Affiliate\Transformers\Affiliates;

use Illuminate\Http\Resources\Json\JsonResource;

class FullAdminAffiliateTransformer extends JsonResource
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
            'level' => $this->resource->level,
            'commission' => $this->resource->commission,
            'commission_type' => $this->resource->commission_type,
            'type' => $this->resource->type,
            'status' => (bool) $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y')
        ];
    }
}