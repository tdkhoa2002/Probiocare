<?php

namespace Modules\Cryperrswap\Transformers\Currencies;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyTransformer extends JsonResource
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
            'network' => $this->resource->network,
            'name' => $this->resource->name,
            'coin' => $this->resource->coin,
            'priority' => $this->resource->priority,
            'code' => $this->resource->code,
            'status' => (bool) $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.cryperrswap.service.destroy', $this->resource->id),
            ],
        ];
    }
}