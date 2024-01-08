<?php

namespace Modules\Page\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PostTransformer extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'is_home' => $this->resource->is_home,
            'type' => $this->resource->type,
            'template' => $this->resource->template,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'translations' => [
                'title' => optional($this->resource->translate(locale()))->title,
                'slug' => optional($this->resource->translate(locale()))->slug,
                'status' => optional($this->resource->translate(locale()))->status,
            ],
            'categories' => $this->resource->categories()->get(),
            'urls' => [
                'delete_url' => route('api.post.post.destroy', $this->resource->id),
            ],
        ];
    }
}
