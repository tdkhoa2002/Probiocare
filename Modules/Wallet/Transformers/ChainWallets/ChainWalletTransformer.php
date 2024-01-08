<?php

namespace Modules\Wallet\Transformers\ChainWallets;

use Illuminate\Http\Resources\Json\JsonResource;

class ChainWalletTransformer extends JsonResource
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
            'blockchain' => $this->resource->blockchain,
            'using' => (bool) $this->resource->using,
            'status' => (bool) $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.wallet.chainwallet.destroy', $this->resource->id),
            ],
        ];
    }
}