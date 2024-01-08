<?php

namespace Modules\Page\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Page\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'page.categories';
        $this->repository = $category;
    }

    public function findCategory($notId)
    {
        $this->clearCache();

        return $this->repository->findCategory($notId);
    }
    
    public function getListCategory()
    {
        $this->clearCache();
        return $this->repository->getListCategory();
    }
}
