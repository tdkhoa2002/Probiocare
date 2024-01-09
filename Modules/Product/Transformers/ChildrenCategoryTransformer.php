<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ChildrenCategoryTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        if (count($this->resource->children()->get()) > 0) {
            return [
                'id' => $this->resource->id,
                'title' => $this->resource->title,
                'children' => getChildCategories($this->resource->children()->get()),
            ];
        }

        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
        ];
    }
}
