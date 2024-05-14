<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $avatar = $this->resource->getAvatar();
        return [
            'id' => $this->resource->id,
            'show_homepage' => (bool) $this->resource->show_homepage,
            'status' => (bool) $this->resource->status,
            'price' => number_format($this->resource->price),
            'price_sale' => number_format($this->resource->price_sale),
            'price_member' => number_format($this->resource->price_member),
            'avatar' => $avatar != "" ? (string) $avatar->path : "",
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'translations' => [
                'title' => optional($this->resource->translate(locale()))->title,
                'slug' => optional($this->resource->translate(locale()))->slug,
            ],
            'urls' => [
                'delete_url' => route('api.product.product.destroy', $this->resource->id),
            ],
        ];
    }
}
