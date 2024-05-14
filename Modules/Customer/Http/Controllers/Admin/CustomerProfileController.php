<?php

namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Entities\CustomerProfile;
use Modules\Customer\Http\Requests\CreateCustomerProfileRequest;
use Modules\Customer\Http\Requests\UpdateCustomerProfileRequest;
use Modules\Customer\Repositories\CustomerProfileRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CustomerProfileController extends AdminBaseController
{
    /**
     * @var CustomerProfileRepository
     */
    private $customerprofile;

    public function __construct(CustomerProfileRepository $customerprofile)
    {
        parent::__construct();

        $this->customerprofile = $customerprofile;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$customerprofiles = $this->customerprofile->all();

        return view('customer::admin.customerprofiles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer::admin.customerprofiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCustomerProfileRequest $request
     * @return Response
     */
    public function store(CreateCustomerProfileRequest $request)
    {
        $this->customerprofile->create($request->all());

        return redirect()->route('admin.customer.customerprofile.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('customer::customerprofiles.title.customerprofiles')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CustomerProfile $customerprofile
     * @return Response
     */
    public function edit(CustomerProfile $customerprofile)
    {
        return view('customer::admin.customerprofiles.edit', compact('customerprofile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CustomerProfile $customerprofile
     * @param  UpdateCustomerProfileRequest $request
     * @return Response
     */
    public function update(CustomerProfile $customerprofile, UpdateCustomerProfileRequest $request)
    {
        $this->customerprofile->update($customerprofile, $request->all());

        return redirect()->route('admin.customer.customerprofile.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('customer::customerprofiles.title.customerprofiles')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CustomerProfile $customerprofile
     * @return Response
     */
    public function destroy(CustomerProfile $customerprofile)
    {
        $this->customerprofile->destroy($customerprofile);

        return redirect()->route('admin.customer.customerprofile.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('customer::customerprofiles.title.customerprofiles')]));
    }
}
