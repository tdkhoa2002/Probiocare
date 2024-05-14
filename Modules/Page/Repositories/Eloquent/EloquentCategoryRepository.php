<?php

namespace Modules\Page\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Page\Events\CategoryIsCreating;
use Modules\Page\Events\CategoryIsUpdating;
use Modules\Page\Events\CategoryWasCreated;
use Modules\Page\Events\CategoryWasDeleted;
use Modules\Page\Events\CategoryWasUpdated;
use Modules\Page\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Modules\Page\Entities\Category;
use Yajra\DataTables\DataTables;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{
    public function create($data)
    {
        event($event = new CategoryIsCreating($data));
        $category = $this->model->create($event->getAttributes());
        event(new CategoryWasCreated($category, $data));
        return $category;
    }

    public function getListCategory()
    {
        $categories = $this->model->select('*');
        return DataTables::of($categories)
            ->addColumn('action', function ($category) {
                return view('page::admin.categories.action', compact('category'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function update($model, $data)
    {
        event($event = new CategoryIsUpdating($model, $data));
        $model->update($event->getAttributes());

        event(new CategoryWasUpdated($model, $data));
        return $model;
    }

    public function destroy($category)
    {
        event(new CategoryWasDeleted($category));

        return $category->delete();
    }

    public function allWidthChildren($menuId)
    {
        return $this->model->with('translations')->whereMenuId($menuId)->orderBy('parent_id')->orderBy('position')->get();
    }

    public function getPageHomePage()
    {
        return $this->model->where('show_homepage', true)->where('status', true)->get();
    }

    public function findCategory($notId)
    {
        return $this->model->where('id', '!=', $notId)->where('parent_id', null)->where('status', true)->get();
    }
}
