<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Category;
use Modules\Product\Http\Requests\CreateCategoryRequest;
use Modules\Product\Http\Requests\UpdateCategoryRequest;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Product\Transformers\FullCategoryTransformer;
use Modules\Product\Transformers\CategoryTransformer;
use Modules\Product\Transformers\ChildrenCategoryTransformer;
use Modules\Product\Transformers\SmallCategoryTransformer;

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
        return SmallCategoryTransformer::collection($this->category->all());
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
            'message' => trans('Product::messages.category created'),
        ]);
    }

    public function find(Request $request)
    {
        $categoryId = $request->categoryId;
        $category = $this->category->find($categoryId);
        return new FullCategoryTransformer($category);
    }

    public function update($categoryId, UpdateCategoryRequest $request)
    {
        $category = $this->category->find($categoryId);
        $this->category->update($category, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('Product::messages.category updated'),
        ]);
    }

    public function destroy(Category $category)
    {
        $this->category->destroy($category);
        return response()->json([
            'errors' => false,
            'message' => trans('Product::messages.category deleted'),
        ]);
    }

    public function getCategoriesWithChildren(Request $request)
    {
        $categories = ChildrenCategoryTransformer::collection($this->category->findCategory($request->categoryId));

        return $categories;
    }
}
