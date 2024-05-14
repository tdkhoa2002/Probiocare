<?php

namespace Modules\Staking\Transformers\PackageTerms;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageTermTransformer extends JsonResource
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
            'day_reward' => $this->resource->day_reward,
            'total_stake' => $this->resource->total_stake,
            'type' => $this->resource->type,
            'title' => $this->resource->title,
            'apr_reward' => $this->resource->apr_reward,
        ];
    }
}
