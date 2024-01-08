<?php

namespace Modules\Cryperrswap\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Cryperrswap\Repositories\ServiceRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentServiceRepository extends EloquentBaseRepository implements ServiceRepository
{
    /**
     * Paginating, ordering and searching through services for server side index table
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $services = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $services->whereHas('translations', function ($query) use ($term) {
                $query->where('title', 'LIKE', "%{$term}%");
            })->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            if (\Str::contains($request->get('order_by'), '.')) {
                $fields = explode('.', $request->get('order_by'));

                $services->with('translations')->join('cryperrswap__service_translations as t', function ($join) {
                    $join->on('cryperrswap__services.id', '=', 't.service_id ');
                })
                    ->where('t.locale', locale())
                    ->groupBy('cryperrswap__services.id')->orderBy("t.{$fields[1]}", $order);
            } else {
                $services->orderBy($request->get('order_by'), $order);
            }
        }

        return $services->paginate($request->get('per_page', 10));
    }

    public function getServiceActive()
    {
        return $this->model->where('status', true)->first();
    }
}
