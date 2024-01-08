<?php

namespace Modules\Wallet\Transformers\Blockchains;

use Illuminate\Http\Resources\Json\JsonResource;

class SmallBlockchainTransformer extends JsonResource
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
            'code' => $this->resource->code,
            'title' => $this->resource->title,
        ];
    }
}
