<?php

namespace Modules\Wallet\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Wallet\Repositories\WalletRepository;

class UpdateBalanceWalletListener
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
        $wallet = $this->walletRepository->find($event->walletId);
        if ($wallet) {
            $this->walletRepository->update($wallet, ['balance' => $event->balance]);
        }
    }
}
