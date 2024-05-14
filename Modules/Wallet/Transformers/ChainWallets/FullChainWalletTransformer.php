<?php

namespace Modules\Wallet\Transformers\ChainWallets;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullChainWalletTransformer extends JsonResource
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
            'address' => $this->resource->address,
            'blockchain_id' => $this->resource->blockchain_id,
            'using' => (bool) $this->resource->using,
            'status' => (bool) $this->resource->status,
        ];
    }
}
