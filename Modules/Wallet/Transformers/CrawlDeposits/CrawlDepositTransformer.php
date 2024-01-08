<?php
namespace Modules\Wallet\Transformers\CrawlDeposits;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\UserProfileTransformer;
use Modules\Wallet\Transformers\Blockchains\SmallBlockchainTransformer;
use Modules\Wallet\Transformers\CrawlHistories\CrawlHistoryTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;

class CrawlDepositTransformer extends JsonResource
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
            'currency'=>new SmallCurrencyTransformer($this->currency),
            'blockchain'=> new SmallBlockchainTransformer($this->blockchain),
            'total' => $this->resource->total,
            'user' =>new UserProfileTransformer($this->user),
            'crawlHistories'=>CrawlHistoryTransformer::collection($this->crawlHistories),
            'created_at'=>$this->created_at
        ];
    }
}
