<?php

namespace Modules\Customer\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Customer\Repositories\PaymentMethodAttrRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentPaymentMethodAttrRepository extends EloquentBaseRepository implements PaymentMethodAttrRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $paymentMethods = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
           
        }
        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $paymentMethods->orderBy($request->get('order_by'), $order);
        }
        return $paymentMethods->paginate($request->get('per_PaymentMethod', 10));
    }
}
