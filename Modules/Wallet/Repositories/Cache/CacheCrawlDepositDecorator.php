<?php

namespace Modules\Wallet\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\CrawlDepositRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCrawlDepositDecorator extends BaseCacheDecorator implements CrawlDepositRepository
{
    public function __construct(CrawlDepositRepository $crawldeposit)
    {
        parent::__construct();
        $this->entityName = 'wallet.crawldeposits';
        $this->repository = $crawldeposit;
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
