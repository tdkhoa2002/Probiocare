<?php

namespace Modules\Trade\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Trade\Entities\Trade;
use Modules\Trade\Libraries\Tatum;

class SendTradeMarket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $price;
    protected $amount;
    protected $pair;
    protected $currency1;
    protected $currency2;
    protected $tradeId;
    public function __construct($type, $price, $amount, $pair, $currency1, $currency2, $tradeId)
    {
        $this->type = $type;
        $this->price = $price;
        $this->amount = $amount;
        $this->pair = $pair;
        $this->currency1 = $currency1;
        $this->currency2 = $currency2;
        $this->tradeId = $tradeId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $tatumApiKey = setting('trade::tatum_api_key');
            $tatum = new Tatum($tatumApiKey);
            $order = $tatum->createTrade($this->type, $this->price, $this->amount, $this->pair, $this->currency1, $this->currency2);
            if (isset($order['error']) && $order['error'] === false) {
                $dataOrder = $order['order'];
                $orderId = $dataOrder['id'];
                Trade::where('id', $this->tradeId)->update(['order_id' => $orderId]);
                return true;
            } else {
                \Log::error($order);
                return false;
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return false;
        }
    }
}
