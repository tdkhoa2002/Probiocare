<?php

namespace Modules\Customer\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCustomerDecorator extends BaseCacheDecorator implements CustomerRepository
{
    public function __construct(CustomerRepository $customer)
    {
        parent::__construct();
        $this->entityName = 'customer.customers';
        $this->repository = $customer;
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

    public function getCustomerWithFloor($sponsor_floor) {
        $key = $this->getBaseKey() . "getCustomerWithFloor.{$sponsor_floor}";

        return $this->remember(function () use ($sponsor_floor) {
            return $this->repository->getCustomerWithFloor($sponsor_floor);
        }, $key);
    }

    public function createAdmin($data) {
        $key = $this->getBaseKey() . "createAdmin";

        return $this->remember(function () use ($data) {
            return $this->repository->createAdmin($data);
        }, $key);
    }
}
