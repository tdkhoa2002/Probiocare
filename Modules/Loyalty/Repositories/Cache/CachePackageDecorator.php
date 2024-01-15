<?php

namespace Modules\Loyalty\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Loyalty\Repositories\PackageRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePackageDecorator extends BaseCacheDecorator implements PackageRepository
{
    public function __construct(PackageRepository $package)
    {
        parent::__construct();
        $this->entityName = 'loyalty.packages';
        $this->repository = $package;
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

    public function getPackagesList()
    {
        $key = $this->getBaseKey() . "getPackagesList";

        return $this->remember(function () {
            return $this->repository->getPackagesList();
        }, $key);
    }
}
