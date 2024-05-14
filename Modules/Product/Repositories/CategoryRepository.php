<?php

namespace Modules\Product\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;

interface CategoryRepository extends BaseRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator;
    public function getCategoryHomepage();
    public function getCategorySidebar();
    public function getCategoryMenu();
    public function findCategory($categoryId);
    public function getCategoryParentHomepage();
   
}
