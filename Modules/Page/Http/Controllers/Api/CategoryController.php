<?php

namespace Modules\Page\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\Category;
use Modules\Page\Http\Requests\CreateCategoryRequest;
use Modules\Page\Http\Requests\UpdateCategoryRequest;
use Modules\Page\Repositories\CategoryRepository;
use Modules\Page\Transformers\FullCategoryTransformer;
use Modules\Page\Transformers\CategoryTransformer;
use Modules\Page\Transformers\CategoryWithChildrenTransformer;

class CategoryController extends Controller
{
    /**
     * @var categoryRepository
     */
    private $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function all()
    {
        return CategoryTransformer::collection($this->category->all());
    }

    public function getCategoriesWithChildren(Request $request)
    {
        $categories = CategoryWithChildrenTransformer::collection($this->category->findCategory($request->categoryId));

        return $categories;
    }

    public function getCategoriesWithFloor(Request $request)
    {
        $categories = CategoryWithChildrenTransformer::collection($this->category->findCategory($request->categoryId));
        return $categories;
    }

    public function indexServerSide(Request $request)
    {
        return CategoryTransformer::collection($this->category->serverPaginationFilteringFor($request));
    }

    public function store(CreateCategoryRequest $request)
    {
        $this->category->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('page::messages.category created'),
        ]);
    }

    public function find($categoryId)
    {
        $category = $this->category->find($categoryId);
        return new FullCategoryTransformer($category);
    }

    public function update(category $category, UpdateCategoryRequest $request)
    {
        if (!isset($request->all()['parent_id'])) {
            $request->merge(['parent_id' => null]);
        }
        $this->category->update($category, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('page::messages.category updated'),
        ]);
    }

    public function destroy(Category $category)
    {
        $this->category->destroy($category);
        return response()->json([
            'errors' => false,
            'message' => trans('page::messages.category deleted'),
        ]);
    }
}
