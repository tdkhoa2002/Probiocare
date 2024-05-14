<?php

namespace Modules\Product\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Product\Repositories\ProductRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Product\Events\ProductWasCreated;
use Modules\Product\Events\ProductWasDeleted;
use Modules\Product\Events\ProductWasUpdated;

class EloquentProductRepository extends EloquentBaseRepository implements ProductRepository
{
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

    /**
     * @param  mixed  $data
     * @return object
     */
    public function create($data)
    {
        $product = $this->model->create($data);
        event(new ProductWasCreated($product, $data));
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
        event(new ProductWasUpdated($model, $data));
        return $model;
    }

    public function destroy($product)
    {
        event(new ProductWasDeleted($product));
        return $product->delete();
    }

    /**
     * @param $slug
     * @param $locale
     * @return object
     */
    public function findBySlugInLocale($slug, $locale)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($slug, $locale) {
                $q->where('slug', $slug);
                $q->where('locale', $locale);
            })->with('translations')->where('status', true)->first();
        }

        return $this->model->where('status', true)->where('slug', $slug)->where('locale', $locale)->first();
    }

    public function getProductNewArrivals()
    {
        return $this->model->where('status', true)->where('is_new_arrivals', true)->limit(10)->orderBy('created_at', 'DESC')->get();
    }
    public function getProductEditorChoice()
    {
        return $this->model->where('status', true)->where('is_best_choice', true)->limit(10)->orderBy('created_at', 'DESC')->get();
    }
    public function getProductBestSelling()
    {
        return $this->model->where('status', true)->where('is_best_selling', true)->limit(10)->orderBy('created_at', 'DESC')->paginate(2);
    }

    public function getProductByCategory($categoryId, $s)
    {
        $products = $this->model->where('status', true)->where('category_id', $categoryId);
        if ($s != null) {
            if ($s == 'l') {
                $products->where('is_new_arrivals', true);
            }

            if ($s == 'b') {
                $products->where('is_best_selling', true);
            }
            if ($s == 'd') {
                $products->where('is_promotion', true);
            }

            if ($s == 'ph') {
                $products->orderBy('price_sale', 'DESC');
            } elseif ($s = 'pl') {
                $products->orderBy('price_sale', 'ASC');
            } else {
                $products->orderBy('created_at', 'DESC');
            }
        }
        return $products->paginate(12);
    }

    public function getAllProducts()
    {
        $products = $this->model->where('status', true);
        return $products->paginate(2);
    }

    public function getProductRelated($categoryId, $productId)
    {
        return $this->model->where('status', true)
            ->whereNot('id', $productId)
            ->where('category_id', $categoryId)
            ->orderBy('created_at', 'DESC')->limit(10)->get();
    }

    public function getProductByKeyword($keyword, $s, $cid, $locale)
    {
        $products = $this->model->whereHas('translations', function (Builder $q) use ($keyword, $locale) {
            $q->where('title', 'LIKE', '%' . $keyword . '%');
            $q->where('locale', $locale);
        })->with('translations')->where('status', true);
        if ($cid != null && $cid != "") {
            $products->where('category_id', $cid);
        }
        if ($s != null) {
            if ($s == 'l') {
                $products->where('is_new_arrivals', true);
            }

            if ($s == 'b') {
                $products->where('is_best_selling', true);
            }
            if ($s == 'd') {
                $products->where('is_promotion', true);
            }

            if ($s == 'ph') {
                $products->orderBy('price_sale', 'DESC');
            } elseif ($s = 'pl') {
                $products->orderBy('price_sale', 'ASC');
            } else {
                $products->orderBy('created_at', 'DESC');
            }
        }
        return $products->paginate(12);
    }

    public function getProductByIds($ids)
    {
        return $this->model->where('status', true)->whereIn('id', $ids)->orderBy('created_at', 'DESC')->get();
    }
}
