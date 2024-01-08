<?php

namespace Modules\Wallet\Transformers\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Transformers\Blockchains\FullBlockchainTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class ListWithdrawTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $txhash = $this->resource->txhash;
        $blockchain = $this->blockchain;
        $link = '';
        if ($this->resource->status == 'COMPLETED' && $blockchain) {
            $link = $blockchain->scan . "/tx/" . $txhash;
            $txhash = substr($txhash, 0, 10);
        }
        return [
            'id' => $this->resource->id,
            'blockchain' => new FullBlockchainTransformer($this->blockchain),
            'currency' => new SmallCurrencyTransformer($this->currency),
            'action' => $this->resource->action,
            'amount' => $this->resource->amount,
            'status' => $this->resource->status,
            'txhash' => $txhash,
            'link_tx_hash' => $link,
            'created_at' => $this->resource->created_at->format('d-m-Y H:i:s'),

        ];
    }
}
