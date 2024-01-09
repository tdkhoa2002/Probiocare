<?php

namespace Modules\Product\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Product\Entities\Category;
use Modules\Product\Repositories\CategoryRepository;
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
        return view('product::admin.categories.index');
    }

    public function create()
    {
        return view('product::admin.categories.create');
    }

    
    public function edit()
    {
        return view('product::admin.categories.edit');
    }

}
