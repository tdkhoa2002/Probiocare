<?php

namespace Modules\Product\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Product\Events\CategoryWasCreated;
use Modules\Product\Events\CategoryWasDeleted;
use Modules\Product\Events\CategoryWasUpdated;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{
    /**
     * @param  mixed  $data
     * @return object
     */
    public function create($data)
    {
        $product = $this->model->create($data);
        event(new CategoryWasCreated($product, $data));
        return $product;
    }

    /**
     * @param $model
     * @param  array  $data
     * @return object
     */
    public function update($model, $data)
    {
        $model->update($data);
        event(new CategoryWasUpdated($model, $data));
        return $model;
    }

    public function destroy($product)
    {
        event(new CategoryWasDeleted($product));
        return $product->delete();
    }

    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $categorys = $this->allWithBuilder();
        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $categorys->whereHas('translations', function ($query) use ($term) {
                $query->where('title', 'LIKE', "%{$term}%");
                $query->orWhere('slug', 'LIKE', "%{$term}%");
            })->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $categorys->orderBy($request->get('order_by'), $order);
        }

        return $categorys->paginate($request->get('per_page', 10));
    }

    public function getCategoryHomepage()
    {
        return $this->model->where('show_homepage', true)->where('status', true)->get();
    }

    public function getCategoryParentHomepage()
    {
        return $this->model->where('show_homepage', true)
            ->where('parent_id', null)
            ->with('children', function ($query) {
                $query->where('show_homepage', true) ->where('status', true)->with('products', function ($query) {
                    $query->where('show_homepage', true) ->where('status', true);
                });
            })
            ->with('products', function ($query) {
                $query->where('show_homepage', true) ->where('status', true);
            })
            ->where('status', true)->get();
    }


    
    public function getCategorySidebar()
    {
        return $this->model->where('show_sidebar', true)->where('status', true)->get();
    }

    public function getCategoryMenu()
    {
        return $this->model->where('show_menu', true)
            ->where('parent_id', null)
            ->with('children', function ($query) {
                $query->where('show_menu', true);
            })->where('status', true)->get();
    }

    public function findCategory($categoryId)
    {
        return $this->model->where('id', '!=', $categoryId)->where('parent_id', null)->where('status', true)->get();
    }
}
