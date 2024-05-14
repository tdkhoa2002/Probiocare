<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOrderTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $path = $this->resource->getAvatar()->path->getUrl() ?? "";
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'avatar' =>   $path
        ];
    }
}
