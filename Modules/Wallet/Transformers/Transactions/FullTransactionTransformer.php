<?php

namespace Modules\Wallet\Transformers\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullTransactionTransformer extends JsonResource
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
            'status' => (bool) $this->resource->status,
        ];
    }
}
