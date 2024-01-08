<?php

namespace Modules\Staking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Staking\Entities\Commission;
use Modules\Staking\Http\Requests\CreateCommissionRequest;
use Modules\Staking\Http\Requests\UpdateCommissionRequest;
use Modules\Staking\Repositories\CommissionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CommissionController extends AdminBaseController
{
    /**
     * @var CommissionRepository
     */
    private $commission;

    public function __construct(CommissionRepository $commission)
    {
        parent::__construct();

        $this->commission = $commission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$commissions = $this->commission->all();

        return view('staking::admin.commissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('staking::admin.commissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCommissionRequest $request
     * @return Response
     */
    public function store(CreateCommissionRequest $request)
    {
        $this->commission->create($request->all());

        return redirect()->route('admin.staking.commission.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('staking::commissions.title.commissions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Commission $commission
     * @return Response
     */
    public function edit(Commission $commission)
    {
        return view('staking::admin.commissions.edit', compact('commission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Commission $commission
     * @param  UpdateCommissionRequest $request
     * @return Response
     */
    public function update(Commission $commission, UpdateCommissionRequest $request)
    {
        $this->commission->update($commission, $request->all());

        return redirect()->route('admin.staking.commission.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('staking::commissions.title.commissions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Commission $commission
     * @return Response
     */
    public function destroy(Commission $commission)
    {
        $this->commission->destroy($commission);

        return redirect()->route('admin.staking.commission.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('staking::commissions.title.commissions')]));
    }
}
