<?php

namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Entities\CustomerCode;
use Modules\Customer\Http\Requests\CreateCustomerCodeRequest;
use Modules\Customer\Http\Requests\UpdateCustomerCodeRequest;
use Modules\Customer\Repositories\CustomerCodeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CustomerCodeController extends AdminBaseController
{
    /**
     * @var CustomerCodeRepository
     */
    private $customercode;

    public function __construct(CustomerCodeRepository $customercode)
    {
        parent::__construct();

        $this->customercode = $customercode;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$customercodes = $this->customercode->all();

        return view('customer::admin.customercodes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer::admin.customercodes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCustomerCodeRequest $request
     * @return Response
     */
    public function store(CreateCustomerCodeRequest $request)
    {
        $this->customercode->create($request->all());

        return redirect()->route('admin.customer.customercode.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('customer::customercodes.title.customercodes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CustomerCode $customercode
     * @return Response
     */
    public function edit(CustomerCode $customercode)
    {
        return view('customer::admin.customercodes.edit', compact('customercode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CustomerCode $customercode
     * @param  UpdateCustomerCodeRequest $request
     * @return Response
     */
    public function update(CustomerCode $customercode, UpdateCustomerCodeRequest $request)
    {
        $this->customercode->update($customercode, $request->all());

        return redirect()->route('admin.customer.customercode.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('customer::customercodes.title.customercodes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CustomerCode $customercode
     * @return Response
     */
    public function destroy(CustomerCode $customercode)
    {
        $this->customercode->destroy($customercode);

        return redirect()->route('admin.customer.customercode.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('customer::customercodes.title.customercodes')]));
    }
}
