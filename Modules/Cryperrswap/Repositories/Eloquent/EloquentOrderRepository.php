<?php

namespace Modules\Cryperrswap\Repositories\Eloquent;

use Modules\Cryperrswap\Repositories\OrderRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOrderRepository extends EloquentBaseRepository implements OrderRepository
{
    public function getOrderProccess()
    {
        return $this->model->whereIn('status', ["NEW", "PENDING", "EXCHANGE", "WITHDRAW"])->orderBy('created_at', 'asc')->limit(20)->get();
    }
}
