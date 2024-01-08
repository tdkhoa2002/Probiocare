<?php

namespace Modules\Wallet\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Wallet\Repositories\CrawlHistoryRepository;

class CreateCrawlHistoryListener
{
    protected $crawlHistoryRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CrawlHistoryRepository $crawlHistoryRepository)
    {
        $this->crawlHistoryRepository = $crawlHistoryRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        return $this->crawlHistoryRepository->create($event->data);
    }
}
