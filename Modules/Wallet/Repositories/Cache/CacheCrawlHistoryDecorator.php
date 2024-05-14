<?php

namespace Modules\Wallet\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\CrawlHistoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCrawlHistoryDecorator extends BaseCacheDecorator implements CrawlHistoryRepository
{
    public function __construct(CrawlHistoryRepository $crawlhistory)
    {
        parent::__construct();
        $this->entityName = 'wallet.crawlhistories';
        $this->repository = $crawlhistory;
    }

    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $page = $request->get('page');
        $order = $request->get('order');
        $orderBy = $request->get('order_by');
        $perPage = $request->get('per_page');
        $search = $request->get('search');

        $key = $this->getBaseKey() . "serverPaginationFilteringFor.{$page}-{$order}-{$orderBy}-{$perPage}-{$search}";

        return $this->remember(function () use ($request) {
            return $this->repository->serverPaginationFilteringFor($request);
        }, $key);
    }
}
