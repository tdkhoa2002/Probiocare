<?php

namespace Modules\Cryperrswap\Transformers\Services;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceTransformer extends JsonResource
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
            'title' => $this->resource->title,
            'code' => $this->resource->code,
            'status' => (bool) $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.cryperrswap.service.destroy', $this->resource->id),
            ],
        ];
    }
}
