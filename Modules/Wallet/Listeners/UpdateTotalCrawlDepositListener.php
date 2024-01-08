<?php

namespace Modules\Wallet\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Wallet\Repositories\CrawlDepositRepository;

class UpdateTotalCrawlDepositListener
{
    protected $crawlDepositRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CrawlDepositRepository $crawlDepositRepository)
    {
        $this->crawlDepositRepository = $crawlDepositRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $crawlDeposit = $this->crawlDepositRepository->find($event->crawlDepositId);
        if ($crawlDeposit) {
            $this->crawlDepositRepository->update($crawlDeposit, ['total' => $crawlDeposit->total + $event->amount]);
        }
    }
}
