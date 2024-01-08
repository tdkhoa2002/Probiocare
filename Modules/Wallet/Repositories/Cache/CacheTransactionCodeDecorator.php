<?php

namespace Modules\Wallet\Repositories\Cache;

use Modules\Wallet\Repositories\TransactionCodeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTransactionCodeDecorator extends BaseCacheDecorator implements TransactionCodeRepository
{
    public function __construct(TransactionCodeRepository $transactioncode)
    {
        parent::__construct();
        $this->entityName = 'wallet.transactioncodes';
        $this->repository = $transactioncode;
    }
}
