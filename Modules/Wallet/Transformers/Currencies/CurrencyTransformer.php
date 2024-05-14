<?php

namespace Modules\Wallet\Transformers\Currencies;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Wallet\Enums\TypeTransactionActionEnum;

class CurrencyTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        // $transactions = $this->transactions;
        // $deposit = $transactions->where('action', 'DEPOSIT')->sum('amount');
        // $withdraw = $transactions->where('action', 'WITHDRAW')->sum('amount');
        $onhold = 0;
        $wallets = $this->wallets;
        foreach ($wallets  as $wallet) {
            $walletChains = $wallet->walletChains;
            $total = $walletChains->sum('onhold');
            $onhold += $total;
        }
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'total_supply' => $this->resource->total_supply,
            'code' => $this->resource->code,
            'icon' => $this->resource->getIcon()->path_string ?? "",
            'status' => (bool) $this->resource->status,
            // 'deposit' => $deposit,
            // 'withdraw' => $withdraw,
            'onhold' => $onhold,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.wallet.currency.destroy', $this->resource->id),
            ],
        ];
    }
}
