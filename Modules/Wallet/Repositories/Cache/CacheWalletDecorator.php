<?php

namespace Modules\Wallet\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheWalletDecorator extends BaseCacheDecorator implements WalletRepository
{
    public function __construct(WalletRepository $wallet)
    {
        parent::__construct();
        $this->entityName = 'wallet.wallets';
        $this->repository = $wallet;
    }

    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $page = $request->get('page');
        $order = $request->get('order');
        $orderBy = $request->get('order_by');
        $perPage = $request->get('per_page');
        $search = $request->get('search');
        $search = implode('-',$search);
        $key = $this->getBaseKey() . "serverPaginationFilteringFor.{$page}-{$order}-{$orderBy}-{$perPage}-{$search}";

        return $this->remember(function () use ($request) {
            return $this->repository->serverPaginationFilteringFor($request);
        }, $key);
    }
}
