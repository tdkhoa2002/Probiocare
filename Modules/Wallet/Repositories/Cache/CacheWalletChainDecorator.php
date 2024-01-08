<?php

namespace Modules\Wallet\Repositories\Cache;

use Modules\Wallet\Repositories\WalletChainRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheWalletChainDecorator extends BaseCacheDecorator implements WalletChainRepository
{
    public function __construct(WalletChainRepository $walletchain)
    {
        parent::__construct();
        $this->entityName = 'wallet.walletchains';
        $this->repository = $walletchain;
    }

    public function findWalletChainByBlockchain($customerId, $blockchainIds)
    {
        $key = $this->getBaseKey() . "findWalletChainByBlockchain.{$blockchainIds}.{$customerId}";

        return $this->remember(function () use ($customerId, $blockchainIds) {
            return $this->repository->findWalletChainByBlockchain($customerId, $blockchainIds);
        }, $key);
    }

    public function getWalletCanCrawl($onhold, $blockchainId, $currencyId)
    {
        $key = $this->getBaseKey() . "getWalletCanCrawl.{$onhold}.{$blockchainId}.{$currencyId}";

        return $this->remember(function () use ($onhold, $blockchainId, $currencyId) {
            return $this->repository->getWalletCanCrawl($onhold, $blockchainId, $currencyId);
        }, $key);
    }

    public function findWalletByAddress($address) {
        $key = $this->getBaseKey() . "findWalletByAddress.{$address}";

        return $this->remember(function () use ($address) {
            return $this->repository->findWalletByAddress($address);
        }, $key);
    }
}
