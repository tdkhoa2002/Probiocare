<?php

namespace Modules\Product\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;

interface ProductRepository extends BaseRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator;
    public function findBySlugInLocale($slug, $locale);
    public function getProductNewArrivals();
    public function getProductEditorChoice();
    public function getProductBestSelling();
    public function getProductByCategory($categoryId, $s);
    public function getProductByKeyword($keyword, $s, $cid, $locale);
    public function getProductByIds($ids);
    public function getProductRelated($categoryId, $productId);
    public function getAllProducts();
}
