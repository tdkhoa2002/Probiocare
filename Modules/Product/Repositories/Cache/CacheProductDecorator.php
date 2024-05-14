<?php

namespace Modules\Product\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Product\Repositories\ProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductDecorator extends BaseCacheDecorator implements ProductRepository
{
    public function __construct(ProductRepository $product)
    {
        parent::__construct();
        $this->entityName = 'product.products';
        $this->repository = $product;
    }

    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $page = $request->get('page');
        $order = $request->get('order');
        $orderBy = $request->get('order_by');
        $perPage = $request->get('per_page');
        $search = $request->get('search');

        $key = $this->getBaseKey() . "serverPaginationFilteringFor.{$page}-{$order}-{$orderBy}-{$perPage}-{$search}";

        return $this->remember(function () use ($request) {
            return $this->repository->serverPaginationFilteringFor($request);
        }, $key);
    }

    /**
     * @param $slug
     * @param $locale
     * @return object
     */
    public function findBySlugInLocale($slug, $locale)
    {
        $key = $this->getBaseKey() . "findBySlugInLocale.{$slug}-{$locale}";
        return $this->remember(function () use ($slug, $locale) {
            return $this->repository->findBySlugInLocale($slug, $locale);
        }, $key);
    }

    public function getProductNewArrivals()
    {
        $key = $this->getBaseKey() . "getProductNewArrivals";
        return $this->remember(function () {
            return $this->repository->getProductNewArrivals();
        }, $key);
    }
    public function getProductEditorChoice()
    {
        $key = $this->getBaseKey() . "getProductEditorChoice";
        return $this->remember(function () {
            return $this->repository->getProductEditorChoice();
        }, $key);
    }
    public function getProductBestSelling()
    {
        $key = $this->getBaseKey() . "getProductBestSelling";
        return $this->remember(function () {
            return $this->repository->getProductBestSelling();
        }, $key);
    }

    public function getProductByCategory($categoryId, $s)
    {
        $key = $this->getBaseKey() . "getProductByCategory" . $categoryId . $s;
        return $this->remember(function () use ($categoryId, $s) {
            return $this->repository->getProductByCategory($categoryId, $s);
        }, $key);
    }

    public function getProductByKeyword($keyword, $s, $cid, $locale)
    {
        $key = $this->getBaseKey() . "getProductByKeyword" . $keyword . '-' . $locale . '' . $s . '' . $cid;
        return $this->remember(function () use ($keyword, $s, $cid, $locale) {
            return $this->repository->getProductByKeyword($keyword, $s, $cid, $locale);
        }, $key);
    }

    public function getProductRelated($categoryId, $productId)
    {
        $key = $this->getBaseKey() . "getProductRelated" . $categoryId . '-' . $productId;
        return $this->remember(function () use ($categoryId, $productId) {
            return $this->repository->getProductRelated($categoryId, $productId);
        }, $key);
    }

    public function getProductByIds($ids)
    {
        $key = $this->getBaseKey() . "getProductByIds";
        return $this->remember(function () use ($ids) {
            return $this->repository->getProductByIds($ids);
        }, $key);
    }

    public function getAllProducts()
    {
        $key = $this->getBaseKey() . "getAllProducts";
        return $this->remember(function () {
            return $this->repository->getAllProducts();
        }, $key);
    }
}
