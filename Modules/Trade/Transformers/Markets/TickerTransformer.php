<?php

namespace Modules\Trade\Transformers\Markets;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class TickerTransformer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return  [
                'base_id' => $this->resource->currency_id,
                'symbol' => $this->resource->symbol,
                'base_currency' => new SmallCurrencyTransformer($this->resource->currency),
                'quote_id' => $this->resource->currency_pair_id,
                'quote_currency' => new SmallCurrencyTransformer($this->resource->currencyPair),
                'last_price' => $this->resource->price,
                'last_price_usd' => $this->resource->price * $this->resource->currencyPair->usd_rate,
                'base_volume' => $this->resource->tradeHistories->sum('amount'),
                'quote_volume' => $this->resource->tradeHistories->sum('amount_pair'),
                'base_volume_24h' => $this->resource->volume_24h,
                'quote_volume_24h' => $this->resource->volume_pair_24h,
                'isFrozen' => 0
            ];
    }
}
