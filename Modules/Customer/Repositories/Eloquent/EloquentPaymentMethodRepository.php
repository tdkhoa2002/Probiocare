<?php

namespace Modules\Customer\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Customer\Repositories\PaymentMethodRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Customer\Events\PaymentMethodWasCreated;
use Modules\Customer\Events\PaymentMethodWasDeleted;
use Modules\Customer\Events\PaymentMethodWasUpdated;

class EloquentPaymentMethodRepository extends EloquentBaseRepository implements PaymentMethodRepository
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

    public function create($data)
    {
        $paymentMethod = $this->model->create($data);
        event(new PaymentMethodWasCreated($paymentMethod, $data));
        return $paymentMethod;
    }

    /**
     * @param $model
     * @param  array  $data
     * @return object
     */
    public function update($model, $data)
    {
        $model->update($data);
        event(new PaymentMethodWasUpdated($model, $data));
        return $model;
    }

    public function destroy($paymentMethod)
    {
        event(new PaymentMethodWasDeleted($paymentMethod));
        return $paymentMethod->delete();
    }
}
