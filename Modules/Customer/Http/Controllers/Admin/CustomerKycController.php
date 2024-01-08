<?php

namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Entities\CustomerKyc;
use Modules\Customer\Http\Requests\CreateCustomerKycRequest;
use Modules\Customer\Http\Requests\UpdateCustomerKycRequest;
use Modules\Customer\Repositories\CustomerKycRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CustomerKycController extends AdminBaseController
{
    /**
     * @var CustomerKycRepository
     */
    private $customerkyc;

    public function __construct(CustomerKycRepository $customerkyc)
    {
        parent::__construct();

        $this->customerkyc = $customerkyc;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$customerkycs = $this->customerkyc->all();

        return view('customer::admin.customerkycs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer::admin.customerkycs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCustomerKycRequest $request
     * @return Response
     */
    public function store(CreateCustomerKycRequest $request)
    {
        $this->customerkyc->create($request->all());

        return redirect()->route('admin.customer.customerkyc.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('customer::customerkycs.title.customerkycs')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CustomerKyc $customerkyc
     * @return Response
     */
    public function edit(CustomerKyc $customerkyc)
    {
        return view('customer::admin.customerkycs.edit', compact('customerkyc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CustomerKyc $customerkyc
     * @param  UpdateCustomerKycRequest $request
     * @return Response
     */
    public function update(CustomerKyc $customerkyc, UpdateCustomerKycRequest $request)
    {
        $this->customerkyc->update($customerkyc, $request->all());

        return redirect()->route('admin.customer.customerkyc.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('customer::customerkycs.title.customerkycs')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CustomerKyc $customerkyc
     * @return Response
     */
    public function destroy(CustomerKyc $customerkyc)
    {
        $this->customerkyc->destroy($customerkyc);

        return redirect()->route('admin.customer.customerkyc.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('customer::customerkycs.title.customerkycs')]));
    }
}
