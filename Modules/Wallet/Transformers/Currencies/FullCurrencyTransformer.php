<?php

namespace Modules\Wallet\Transformers\Currencies;

use Illuminate\Http\Resources\Json\JsonResource;

class FullCurrencyTransformer extends JsonResource
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
            'icon' => $this->resource->getIcon()->path_string ?? "",
            'type' => $this->resource->type,
            'min_crawl' => $this->resource->min_crawl,
            'transfer_fee' => $this->resource->transfer_fee,
            'transfer_fee_type' => $this->resource->transfer_fee_type,
            'swap_enable' => $this->resource->swap_enable != null ? json_decode($this->resource->swap_enable) : null,
            'swap_fee' => $this->resource->swap_fee,
            'swap_fee_type' => $this->resource->swap_fee_type,
            'min_swap' => $this->resource->min_swap,
            'max_swap' => $this->resource->max_swap,
            'usd_rate' => $this->resource->usd_rate,
            'total_supply' => $this->resource->total_supply,
            'link_rate' => $this->resource->link_rate,
            'status' => (bool) $this->resource->status,
        ];
    }
}
