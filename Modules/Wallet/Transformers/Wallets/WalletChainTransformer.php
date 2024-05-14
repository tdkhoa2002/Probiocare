<?php
namespace Modules\Wallet\Transformers\Wallets;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Customer\Transformers\Customers\SmallCustomerTransformer;
use Modules\Wallet\Transformers\Blockchains\FullBlockchainTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class WalletChainTransformer extends JsonResource
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
            'addressTag'=> $this->resource->addressTag,
            'blockchain_id'=> $this->resource->blockchain_id,
            'blockchain'=> new FullBlockchainTransformer($this->blockchain),
            'onhold'=> $this->resource->onhold,
            'is_sync'=> $this->resource->is_sync,
        ];
    }
}
