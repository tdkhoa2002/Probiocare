<?php

namespace Modules\Trade\Transformers\Market;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class DetailPairInfoTransformer extends JsonResource
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
            'symbol' => $this->resource->symbol,
            'base' => new SmallCurrencyTransformer($this->resource->currency),
            'quote' => new SmallCurrencyTransformer($this->resource->currencyPair),
            'price' => $this->resource->price,
            'price_change_24h' => $this->resource->price_change_24h,
            'hight_24h' => $this->resource->hight_24h,
            'low_24h' => $this->resource->low_24h,
            'volume_24h' => $this->resource->volume_24h,
            'volume_pair_24h' => $this->resource->volume_pair_24h,
            'url_detail' => route('fe.trade.trade.pair',$this->resource->symbol),
        ];
    }
}
