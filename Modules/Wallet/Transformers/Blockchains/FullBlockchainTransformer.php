<?php

namespace Modules\Wallet\Transformers\Blockchains;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullBlockchainTransformer extends JsonResource
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
            'native_token' => $this->resource->native_token,
            'scan' => $this->resource->scan,
            'rpc' => $this->resource->rpc,
            'type' => $this->resource->type,
            'chainid' => $this->resource->chainid,
            'wallet_receive' => $this->resource->wallet_receive,
            'status' => (bool) $this->resource->status,
        ];
    }
}
