<?php
namespace Modules\Wallet\Transformers\CrawlHistories;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Wallet\Transformers\Wallets\SmallWalletChainTransformer;

class CrawlHistoryTransformer extends JsonResource
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
            'wallet'=>new SmallWalletChainTransformer($this->walletChain),
            'amount' => $this->resource->amount,
            'txhash' => $this->resource->txhash,
        ];
    }
}
