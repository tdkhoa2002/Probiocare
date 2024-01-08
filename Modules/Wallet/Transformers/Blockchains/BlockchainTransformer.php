<?php

namespace Modules\Wallet\Transformers\Blockchains;

use Illuminate\Http\Resources\Json\JsonResource;

class BlockchainTransformer extends JsonResource
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
            'type' => $this->resource->type,
            'chainid' => $this->resource->chainid,
            'status' => (bool) $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.wallet.blockchain.destroy', $this->resource->id),
            ],
        ];
    }
}