<?php

namespace Modules\Page\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Entities\Page;
use Modules\Page\Http\Requests\CreatePageRequest;
use Modules\Page\Http\Requests\UpdatePageRequest;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Transformers\FullPageTransformer;
use Modules\Page\Transformers\FullPostTransformer;
use Modules\Page\Transformers\PageTransformer;
use Modules\Page\Transformers\PostTransformer;

class PostController extends Controller
{
    /**
     * @var PageRepository
     */
    private $page;

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
    }

    public function index()
    {
        return PostTransformer::collection($this->page->all());
    }

    public function indexServerSide(Request $request)
    {
        return PostTransformer::collection($this->page->serverPaginationFilteringFor($request));
    }

    public function store(CreatePageRequest $request)
    {

        $page = $this->page->create($request->except(['categories']));

        if (isset($request->all()['categories'])) {
            $page->categories()->attach($request->all()['categories']);
        }

        return response()->json([
            'errors' => false,
            'message' => trans('page::messages.page created'),
        ]);
    }

    public function find($id)
    {
        $page = $this->page->find($id);
        return new FullPostTransformer($page);
    }

    public function update($id, UpdatePageRequest $request)
    {
        $page = $this->page->find($id);

        if ($page->type == 'page') {
            return response()->json([
                'errors' => true,
                'message' => trans('page::messages.page error'),
            ]);
        }

        $page = $this->page->update($page, $request->except(['categories']));

        if (isset($request->all()['categories'])) {
            $page->categories()->detach();
            $page->categories()->attach($request->all()['categories']);
        }

        return response()->json([
            'errors' => false,
            'message' => trans('page::messages.page updated'),
        ]);
    }

    public function destroy($id)
    {

        $page = $this->page->find($id);

        if ($page->type == 'page') {
            return response()->json([
                'errors' => true,
                'message' => trans('page::messages.page error'),
            ]);
        }

        $this->page->destroy($page);

        return response()->json([
            'errors' => false,
            'message' => trans('page::messages.page deleted'),
        ]);
    }
}
