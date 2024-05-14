<?php

namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Entities\CustomerSocial;
use Modules\Customer\Http\Requests\CreateCustomerSocialRequest;
use Modules\Customer\Http\Requests\UpdateCustomerSocialRequest;
use Modules\Customer\Repositories\CustomerSocialRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CustomerSocialController extends AdminBaseController
{
    /**
     * @var CustomerSocialRepository
     */
    private $customersocial;

    public function __construct(CustomerSocialRepository $customersocial)
    {
        parent::__construct();

        $this->customersocial = $customersocial;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$customersocials = $this->customersocial->all();

        return view('customer::admin.customersocials.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer::admin.customersocials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCustomerSocialRequest $request
     * @return Response
     */
    public function store(CreateCustomerSocialRequest $request)
    {
        $this->customersocial->create($request->all());

        return redirect()->route('admin.customer.customersocial.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('customer::customersocials.title.customersocials')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CustomerSocial $customersocial
     * @return Response
     */
    public function edit(CustomerSocial $customersocial)
    {
        return view('customer::admin.customersocials.edit', compact('customersocial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CustomerSocial $customersocial
     * @param  UpdateCustomerSocialRequest $request
     * @return Response
     */
    public function update(CustomerSocial $customersocial, UpdateCustomerSocialRequest $request)
    {
        $this->customersocial->update($customersocial, $request->all());

        return redirect()->route('admin.customer.customersocial.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('customer::customersocials.title.customersocials')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CustomerSocial $customersocial
     * @return Response
     */
    public function destroy(CustomerSocial $customersocial)
    {
        $this->customersocial->destroy($customersocial);

        return redirect()->route('admin.customer.customersocial.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('customer::customersocials.title.customersocials')]));
    }
}
