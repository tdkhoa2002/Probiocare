<?php

namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Entities\CustomerDevice;
use Modules\Customer\Http\Requests\CreateCustomerDeviceRequest;
use Modules\Customer\Http\Requests\UpdateCustomerDeviceRequest;
use Modules\Customer\Repositories\CustomerDeviceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CustomerDeviceController extends AdminBaseController
{
    /**
     * @var CustomerDeviceRepository
     */
    private $customerdevice;

    public function __construct(CustomerDeviceRepository $customerdevice)
    {
        parent::__construct();

        $this->customerdevice = $customerdevice;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$customerdevices = $this->customerdevice->all();

        return view('customer::admin.customerdevices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer::admin.customerdevices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCustomerDeviceRequest $request
     * @return Response
     */
    public function store(CreateCustomerDeviceRequest $request)
    {
        $this->customerdevice->create($request->all());

        return redirect()->route('admin.customer.customerdevice.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('customer::customerdevices.title.customerdevices')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CustomerDevice $customerdevice
     * @return Response
     */
    public function edit(CustomerDevice $customerdevice)
    {
        return view('customer::admin.customerdevices.edit', compact('customerdevice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CustomerDevice $customerdevice
     * @param  UpdateCustomerDeviceRequest $request
     * @return Response
     */
    public function update(CustomerDevice $customerdevice, UpdateCustomerDeviceRequest $request)
    {
        $this->customerdevice->update($customerdevice, $request->all());

        return redirect()->route('admin.customer.customerdevice.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('customer::customerdevices.title.customerdevices')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CustomerDevice $customerdevice
     * @return Response
     */
    public function destroy(CustomerDevice $customerdevice)
    {
        $this->customerdevice->destroy($customerdevice);

        return redirect()->route('admin.customer.customerdevice.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('customer::customerdevices.title.customerdevices')]));
    }
}
