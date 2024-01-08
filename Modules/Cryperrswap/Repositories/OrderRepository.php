<?php

namespace Modules\Cryperrswap\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface OrderRepository extends BaseRepository
{
    public function getOrderProccess();
}
