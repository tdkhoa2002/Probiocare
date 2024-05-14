<?php

namespace Modules\Product\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'product.categories';
        $this->repository = $category;
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

    public function findCategory($categoryId)
    {
        $key = $this->getBaseKey() . "findCategory.{$categoryId}";

        return $this->remember(function () use ($categoryId) {
            return $this->repository->findCategory($categoryId);
        }, $key);
    }

    public function getCategoryHomepage()
    {
        $key = $this->getBaseKey() . "getCategoryHomepage";
        return $this->remember(function () {
            return $this->repository->getCategoryHomepage();
        }, $key);
    }

    public function getCategoryMenu()
    {
        $key = $this->getBaseKey() . "getCategoryMenu";
        return $this->remember(function () {
            return $this->repository->getCategoryMenu();
        }, $key);
    }
    public function getCategoryParentHomepage()
    {
        $key = $this->getBaseKey() . "getCategoryParentHomepage";
        return $this->remember(function () {
            return $this->repository->getCategoryParentHomepage();
        }, $key);
    }

    public function getCategorySidebar()
    {
        $key = $this->getBaseKey() . "getCategorySidebar";
        return $this->remember(function () {
            return $this->repository->getCategorySidebar();
        }, $key);
    }
}
