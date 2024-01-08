<?php

namespace Modules\Cryperrswap\Transformers\Currencies;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
        $service = [
            'id' => $this->resource->id,
            'status' => (bool) $this->resource->status,
            'service_id' => $this->resource->service_id,
            'code' => $this->resource->code,
            'coin' => $this->resource->coin,
            'name' => $this->resource->name,
            'network' => $this->resource->network,
            'tag' => $this->resource->tag,
            'logo' => $this->resource->logo,
            'color' => $this->resource->color,
            'priority' => $this->resource->priority,
            'send' =>  (bool)$this->resource->send,
            'recv' => (bool) $this->resource->recv,
        ];

        return $service;
    }
}
