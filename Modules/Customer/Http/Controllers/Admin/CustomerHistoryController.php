<?php

namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Entities\CustomerHistory;
use Modules\Customer\Http\Requests\CreateCustomerHistoryRequest;
use Modules\Customer\Http\Requests\UpdateCustomerHistoryRequest;
use Modules\Customer\Repositories\CustomerHistoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CustomerHistoryController extends AdminBaseController
{
    /**
     * @var CustomerHistoryRepository
     */
    private $customerhistory;

    public function __construct(CustomerHistoryRepository $customerhistory)
    {
        parent::__construct();

        $this->customerhistory = $customerhistory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$customerhistories = $this->customerhistory->all();

        return view('customer::admin.customerhistories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer::admin.customerhistories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCustomerHistoryRequest $request
     * @return Response
     */
    public function store(CreateCustomerHistoryRequest $request)
    {
        $this->customerhistory->create($request->all());

        return redirect()->route('admin.customer.customerhistory.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('customer::customerhistories.title.customerhistories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CustomerHistory $customerhistory
     * @return Response
     */
    public function edit(CustomerHistory $customerhistory)
    {
        return view('customer::admin.customerhistories.edit', compact('customerhistory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CustomerHistory $customerhistory
     * @param  UpdateCustomerHistoryRequest $request
     * @return Response
     */
    public function update(CustomerHistory $customerhistory, UpdateCustomerHistoryRequest $request)
    {
        $this->customerhistory->update($customerhistory, $request->all());

        return redirect()->route('admin.customer.customerhistory.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('customer::customerhistories.title.customerhistories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CustomerHistory $customerhistory
     * @return Response
     */
    public function destroy(CustomerHistory $customerhistory)
    {
        $this->customerhistory->destroy($customerhistory);

        return redirect()->route('admin.customer.customerhistory.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('customer::customerhistories.title.customerhistories')]));
    }
}
