<?php

namespace Modules\Wallet\Transformers\CurrencyAttrs;

use Illuminate\Http\Resources\Json\JsonResource;

class BlockchainCurrencyAttrTransformer extends JsonResource
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
            'id' => $this->resource->blockchain->id,
            'title' => $this->resource->blockchain->title
        ];
    }
}
