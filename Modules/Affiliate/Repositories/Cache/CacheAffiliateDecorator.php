<?php

namespace Modules\Affiliate\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Affiliate\Repositories\AffiliateRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAffiliateDecorator extends BaseCacheDecorator implements AffiliateRepository
{
    public function __construct(AffiliateRepository $affiliate)
    {
        parent::__construct();
        $this->entityName = 'affiliate.affiliates';
        $this->repository = $affiliate;
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

    public function getAffiliateLastLevel($type)
    {
        $key = $this->getBaseKey() . "getAffiliateLastLevel.{$type}";

        return $this->remember(function () use ($type) {
            return $this->repository->getAffiliateLastLevel($type);
        }, $key);
    }
}
