<?php

namespace Modules\Customer\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Customer\Repositories\PaymentMethodAttrRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePaymentMethodAttrDecorator extends BaseCacheDecorator implements PaymentMethodAttrRepository
{
    public function __construct(PaymentMethodAttrRepository $paymentmethodattr)
    {
        parent::__construct();
        $this->entityName = 'customer.paymentmethodattrs';
        $this->repository = $paymentmethodattr;
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
