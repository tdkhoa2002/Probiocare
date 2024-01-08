<?php

namespace Modules\Peertopeer\Repositories\Cache;

use Modules\Peertopeer\Repositories\AdsPaymentMethodRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAdsPaymentMethodDecorator extends BaseCacheDecorator implements AdsPaymentMethodRepository
{
    public function __construct(AdsPaymentMethodRepository $adspaymentmethod)
    {
        parent::__construct();
        $this->entityName = 'peertopeer.adspaymentmethods';
        $this->repository = $adspaymentmethod;
    }
}
