<?php

namespace Modules\Wallet\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Wallet\Repositories\WalletChainRepository;

class UpdateBalanceOnHoldListener
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
        $walletChain = $this->walletChainRepository->findByAttributes(['wallet_id' => $event->wallet_id, 'blockchain_id' => $event->blockchain_id]);
        if ($walletChain) {
            $this->walletChainRepository->update($walletChain, ['onhold' => $event->amount]);
        }
    }
}
