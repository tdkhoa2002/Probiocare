<?php

namespace Modules\Wallet\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\ChainWalletRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheChainWalletDecorator extends BaseCacheDecorator implements ChainWalletRepository
{
    public function __construct(ChainWalletRepository $chainwallet)
    {
        parent::__construct();
        $this->entityName = 'wallet.chainwallets';
        $this->repository = $chainwallet;
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

    public function findChainWalletAvaliable($blockchainId)
    {
        $key = $this->getBaseKey() . "findChainWalletAvaliable.{$blockchainId}";

        return $this->remember(function () use ($blockchainId) {
            return $this->repository->findChainWalletAvaliable($blockchainId);
        }, $key);
    }

    public function findChainWalletByAddress($address)
    {
        $key = $this->getBaseKey() . "findChainWalletByAddress.{$address}";

        return $this->remember(function () use ($address) {
            return $this->repository->findChainWalletByAddress($address);
        }, $key);
    }
}
