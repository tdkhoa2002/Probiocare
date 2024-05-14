<?php

namespace Modules\Wallet\Transformers\CurrencyAttrs;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FullCurrencyAttrTransformer extends JsonResource
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
            'blockchain_id' => $this->resource->blockchain_id,
            'token_address' => $this->resource->token_address,
            'abi' => $this->resource->abi,
            'native_token' => $this->resource->native_token,
            'decimal' => $this->resource->decimal,
            'withdraw_fee_token' => $this->resource->withdraw_fee_token,
            'withdraw_fee_token_type' => $this->resource->withdraw_fee_token_type,
            'withdraw_fee_chain' => $this->resource->withdraw_fee_chain,
            'value_need_approve' => $this->resource->value_need_approve,
            'value_need_approve_currency' => $this->resource->value_need_approve_currency,
            'max_amount_withdraw_daily' => $this->resource->max_amount_withdraw_daily,
            'max_amount_withdraw_daily_currency' => $this->resource->max_amount_withdraw_daily_currency,
            'max_times_withdraw' => $this->resource->max_times_withdraw,
            'min_withdraw' => $this->resource->min_withdraw,
            'max_withdraw' => $this->resource->max_withdraw,
            'type_withdraw' => $this->resource->type_withdraw,
            'type_deposit' => $this->resource->type_deposit,
            'type_transfer' => $this->resource->type_transfer,
            'status' => (bool) $this->resource->status,
        ];
    }
}
