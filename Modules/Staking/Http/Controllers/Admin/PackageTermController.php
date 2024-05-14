<?php

namespace Modules\Staking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Staking\Entities\PackageTerm;
use Modules\Staking\Http\Requests\CreatePackageTermRequest;
use Modules\Staking\Http\Requests\UpdatePackageTermRequest;
use Modules\Staking\Repositories\PackageTermRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PackageTermController extends AdminBaseController
{
    /**
     * @var PackageTermRepository
     */
    private $packageterm;

    public function __construct(PackageTermRepository $packageterm)
    {
        parent::__construct();

        $this->packageterm = $packageterm;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$packageterms = $this->packageterm->all();

        return view('staking::admin.packageterms.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('staking::admin.packageterms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePackageTermRequest $request
     * @return Response
     */
    public function store(CreatePackageTermRequest $request)
    {
        $this->packageterm->create($request->all());

        return redirect()->route('admin.staking.packageterm.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('staking::packageterms.title.packageterms')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PackageTerm $packageterm
     * @return Response
     */
    public function edit(PackageTerm $packageterm)
    {
        return view('staking::admin.packageterms.edit', compact('packageterm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PackageTerm $packageterm
     * @param  UpdatePackageTermRequest $request
     * @return Response
     */
    public function update(PackageTerm $packageterm, UpdatePackageTermRequest $request)
    {
        $this->packageterm->update($packageterm, $request->all());

        return redirect()->route('admin.staking.packageterm.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('staking::packageterms.title.packageterms')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PackageTerm $packageterm
     * @return Response
     */
    public function destroy(PackageTerm $packageterm)
    {
        $this->packageterm->destroy($packageterm);

        return redirect()->route('admin.staking.packageterm.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('staking::packageterms.title.packageterms')]));
    }
}
