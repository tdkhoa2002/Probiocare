<?php

namespace Modules\Wallet\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Wallet\Repositories\TransactionRepository;

class UpdateTransactionListener
{
    protected $transactionRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $transaction = $this->transactionRepository->find($event->transactionId);
        return $this->transactionRepository->update($transaction, $event->data);
    }
}
