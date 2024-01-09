<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTransformer extends JsonResource
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
            'parent_title' => $this->resource->parent != null ? $this->resource->parent->title : "PARENT",
            'parent_id' => $this->resource->parent != null ? $this->resource->parent->id : null,
            'status' => (bool) $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'translations' => [
                'title' => optional($this->resource->translate(locale()))->title,
                'slug' => optional($this->resource->translate(locale()))->slug,
            ],
            'urls' => [
                'delete_url' => route('api.product.category.destroy', $this->resource->id),
            ],
        ];
    }
}
