<?php

namespace Modules\Loyalty\Repositories\Eloquent;

use Modules\Loyalty\Repositories\CommissionRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCommissionRepository extends EloquentBaseRepository implements CommissionRepository
{
    public function getCommissionLastLevel($packageId)
    {
        return $this->allWithBuilder()->where('package_id', $packageId)->orderBy('level', 'DESC')->first();
    }
}
