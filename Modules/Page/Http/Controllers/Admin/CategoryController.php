<?php

namespace Modules\Page\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Page\Entities\Category;
use Modules\Page\Http\Requests\CreateCategoryRequest;
use Modules\Page\Http\Requests\UpdateCategoryRequest;
use Modules\Page\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CategoryController extends AdminBaseController
{
    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(CategoryRepository $category)
    {
        parent::__construct();

        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('page::admin.categories.index');
    }

    public function getListCategory()
    {
        return $this->category->getListCategory();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories =  $this->getRecursiveCategory();
        return view('page::admin.categories.create', compact('categories'));
    }

    public function getRecursiveCategory()
    {
        $categories = $this->category->getByAttributes([], 'parent_id', 'asc')->toArray();
        return getRecursiveCategory($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePageRequest $request
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->category->create($request->all());

        return redirect()->route('admin.category.category.index')
            ->withSuccess(trans('page::categories.messages.category created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        $categories =  $this->getRecursiveCategory();
        return view('page::admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $this->category->update($category, $request->all());

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.category.category.index')
                ->withSuccess(trans('page::categories.messages.category updated'));
        }

        return redirect()->back()
            ->withSuccess(trans('page::categories.messages.category updated'));
    }

    public function destroy(Category $category)
    {
        $this->category->destroy($category);

        return redirect()->route('admin.category.category.index')
            ->withSuccess(trans('page::categories.messages.category deleted'));
    }
}
