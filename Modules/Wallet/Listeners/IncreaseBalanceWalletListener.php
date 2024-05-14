<?php

namespace Modules\Wallet\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Repositories\WalletRepository;

class IncreaseBalanceWalletListener
{
    protected $walletRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        try {
            $wallet = $this->walletRepository->findByAttributes(['customer_id' => $event->customerId, 'currency_id' => $event->currencyId]);
            if (!$wallet) {
                $dataCreate = [
                    'customer_id' => $event->customerId,
                    'currency_id' => $event->currencyId,
                    'type' => 'CRYPTO',
                    'balance' => 0,
                    'status' => true,
                ];
                $wallet = $this->walletRepository->create($dataCreate);
            }
            $currency = $wallet->currency;
            $newBalance = $wallet->balance + $event->amount;
            $dataCreate = [
                'customer_id' => $event->customerId,
                'currency_id' =>  $event->currencyId,
                'blockchain_id' => null,
                'action' => $event->action,
                'amount' => $event->amount,
                'amount_usd' => $event->amount * $currency->usd_rate,
                'fee' => 0,
                'balance' => $newBalance,
                'balanceBefore' => $wallet->balance,
                'payment_method' => 'CRYPTO',
                'txhash' => random_strings(30),
                'from' => "",
                'to' => "",
                'tag' => null,
                'order' => $event->orderId,
                'note' => null,
                'status' => StatusTransactionEnum::COMPLETED
            ];

            event(new CreateTransaction($dataCreate));
            event(new UpdateBalanceWallet($newBalance, $wallet->id));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
