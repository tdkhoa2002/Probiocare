<?php

namespace Modules\Wallet\Repositories\Cache;

use Modules\Wallet\Repositories\CurrencyAttrRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCurrencyAttrDecorator extends BaseCacheDecorator implements CurrencyAttrRepository
{
    public function __construct(CurrencyAttrRepository $currencyattr)
    {
        parent::__construct();
        $this->entityName = 'wallet.currencyattrs';
        $this->repository = $currencyattr;
    }
}
