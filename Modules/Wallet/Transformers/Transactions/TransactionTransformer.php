<?php

namespace Modules\Wallet\Transformers\Transactions;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionTransformer extends JsonResource
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
        if ($blockchain && $this->resource->status == 'COMPLETED' && ($this->resource->action == 'DEPOSIT' || $this->resource->action == 'WITHDRAW')) {
            $link = $blockchain->scan . "/tx/" . $txhash;
            $txhash = substr($txhash, 0, 10);
        }

        return [
            'id' => $this->resource->id,
            'customer' => $this->resource->customer,
            'currency' => $this->resource->currency,
            'blockchain' => $this->resource->blockchain,
            'action' => $this->resource->action,
            'amount' => $this->resource->amount,
            'amount_usd' => $this->resource->amount_usd,
            'fee' => $this->resource->fee,
            'balance' => $this->resource->balance,
            'balanceBefore' => $this->resource->balanceBefore,
            'payment_method' => $this->resource->payment_method,
            'txhash' => $txhash,
            'link' => $link,
            'from' => $this->resource->from,
            'to' => $this->resource->to,
            'tag' => $this->resource->tag,
            'order' => $this->resource->order,
            'note' => $this->resource->note,
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at->format('d-m-Y H:i:s'),
            'urls' => [
                'delete_url' => route('api.wallet.transaction.destroy', $this->resource->id),
            ],
        ];
    }
}
