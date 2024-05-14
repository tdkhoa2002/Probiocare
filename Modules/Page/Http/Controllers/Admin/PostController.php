<?php

namespace Modules\Page\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Page\Entities\Page;
use Modules\Page\Http\Requests\CreatePageRequest;
use Modules\Page\Http\Requests\UpdatePageRequest;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Repositories\CategoryRepository;

class PostController extends AdminBaseController
{
    /**
     * @var PageRepository
     */
    private $page;
    private $categoryRepository;

    public function __construct(PageRepository $page, CategoryRepository $categoryRepository)
    {
        parent::__construct();

        $this->page = $page;
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        return view('page::admin.posts.index');
    }

    public function getListPost()
    {
        return $this->page->getListPost();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getByAttributes([], 'parent_id', 'asc')->toArray();
        $categories = getRecursiveCategory($categories);
        return view('page::admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePageRequest $request
     * @return Response
     */
    public function store(CreatePageRequest $request)
    {
        $this->page->create($request->all());

        return redirect()->route('admin.post.post.index')
            ->withSuccess(trans('page::messages.post created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     * @return Response
     */
    public function edit($postId)
    {
        $post = $this->page->find($postId);
        if ($post->type == 'page') {
            return redirect()->route('admin.post.post.index')
                ->withErrors(trans('page::messages.page error'));
        }

        $categories = $this->categoryRepository->getByAttributes([], 'parent_id', 'asc')->toArray();
        $categories = getRecursiveCategory($categories);
        $categorySelected = $post->categories->pluck('category_id')->toArray();
        return view('page::admin.posts.edit', compact('post', 'categories', 'categorySelected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Page $page
     * @param  UpdatePageRequest $request
     * @return Response
     */
    public function update($postId, UpdatePageRequest $request)
    {
        $post = $this->page->find($postId);
        if ($post->type == 'page') {
            return redirect()->route('admin.post.post.index')
                ->withErrors(trans('page::messages.page error'));
        }

        $this->page->update($post, $request->all());

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.post.post.index')
                ->withSuccess(trans('page::messages.post updated'));
        }

        return redirect()->back()
            ->withSuccess(trans('page::messages.post updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Page $page
     * @return Response
     */
    public function destroy($postId)
    {
        $post = $this->page->find($postId);
        
        if ($post->type == 'page') {
            return redirect()->route('admin.post.post.index')
                ->withErrors(trans('page::messages.page error'));
        }

        $this->page->destroy($post);

        return redirect()->route('admin.post.post.index')
            ->withSuccess(trans('page::messages.page deleted'));
    }
}
