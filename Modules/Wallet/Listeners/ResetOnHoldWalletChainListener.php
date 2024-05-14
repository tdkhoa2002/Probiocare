<?php

namespace Modules\Wallet\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Wallet\Repositories\WalletChainRepository;

class ResetOnHoldWalletChainListener
{
    protected $walletChainRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(WalletChainRepository $walletChainRepository)
    {
        $this->walletChainRepository = $walletChainRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $walletChain = $this->walletChainRepository->find($event->walletId);
        if ($walletChain) {
            $this->walletChainRepository->update($walletChain, ['onhold' => 0]);
        }
    }
}
