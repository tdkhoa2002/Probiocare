<?php
namespace Modules\Wallet\Transformers\Wallets;

use Illuminate\Http\Resources\Json\JsonResource;

class SmallWalletChainTransformer extends JsonResource
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
            'address'=> $this->resource->address,
            'addressTag'=> $this->resource->addressTag
        ];
    }
}
