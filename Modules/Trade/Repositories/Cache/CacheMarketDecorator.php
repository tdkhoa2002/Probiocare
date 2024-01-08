<?php

namespace Modules\Trade\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Trade\Repositories\MarketRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMarketDecorator extends BaseCacheDecorator implements MarketRepository
{
    public function __construct(MarketRepository $martker)
    {
        parent::__construct();
        $this->entityName = 'trade.markets';
        $this->repository = $martker;
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
    
    public function getListMarket(Request $request): LengthAwarePaginator
    {
        $page = $request->get('page');
        $order = $request->get('order');
        $orderBy = $request->get('order_by');
        $perPage = $request->get('per_page');
        $search = $request->get('search');

        $key = $this->getBaseKey() . "getListMarket.{$page}-{$order}-{$orderBy}-{$perPage}-{$search}";

        return $this->remember(function () use ($request) {
            return $this->repository->getListMarket($request);
        }, $key);
    }
}
