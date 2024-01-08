<?php

namespace Modules\Peertopeer\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Repositories\WalletRepository;

class JobCancelOrderSell implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $order;
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $order = $this->order;
            $assetCurrency = $order->assetCurrency;
            $total_asset_amount = $order->total_asset_amount;
            $wallet = app(WalletRepository::class)->findByAttributes(['customer_id' => $order->customer_id, 'currency_id' => $assetCurrency->id]);
            $newBalance = $wallet->balance + $total_asset_amount;
            event(new UpdateBalanceWallet($newBalance, $wallet->id));
            $transaction = [
                'customer_id' => $order->customer_id,
                'currency_id' => $assetCurrency->id,
                'blockchain_id' => null,
                'action' => TypeTransactionActionEnum::USER_SELL_ADS_CANCEL,
                'amount' => $total_asset_amount,
                'amount_usd' =>  $total_asset_amount * $assetCurrency->usd_rate,
                'fee' => 0,
                'balance' => $newBalance,
                'balanceBefore' => $wallet->balance,
                'payment_method' => 'P2P',
                'txhash' => random_strings(30),
                'from' => null,
                'to' => null,
                'tag' => "",
                'order' => $order->id,
                'note' => "",
                'status' => StatusTransactionEnum::COMPLETED
            ];
            event(new CreateTransaction($transaction));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
