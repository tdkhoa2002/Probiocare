<?php

namespace Modules\Wallet\Transformers\Currencies;

use Illuminate\Http\Resources\Json\JsonResource;

class SmallCurrencySwapTransformer extends JsonResource
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
            'swap_fee' => $this->resource->swap_fee,
            'swap_fee_type' => $this->resource->swap_fee_type,
            'min_swap' => $this->resource->min_swap,
            'max_swap' => $this->resource->max_swap,
            'price_usd' => $this->resource->usd_rate,
            'icon' => $this->resource->getIcon()->path_string ?? "",
            'status' => (bool) $this->resource->status,
        ];
    }
}
