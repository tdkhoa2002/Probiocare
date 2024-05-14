<?php

namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Entities\PaymentMethodAttr;
use Modules\Customer\Http\Requests\CreatePaymentMethodAttrRequest;
use Modules\Customer\Http\Requests\UpdatePaymentMethodAttrRequest;
use Modules\Customer\Repositories\PaymentMethodAttrRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PaymentMethodAttrController extends AdminBaseController
{
    /**
     * @var PaymentMethodAttrRepository
     */
    private $paymentmethodattr;

    public function __construct(PaymentMethodAttrRepository $paymentmethodattr)
    {
        parent::__construct();

        $this->paymentmethodattr = $paymentmethodattr;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$paymentmethodattrs = $this->paymentmethodattr->all();

        return view('customer::admin.paymentmethodattrs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer::admin.paymentmethodattrs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePaymentMethodAttrRequest $request
     * @return Response
     */
    public function store(CreatePaymentMethodAttrRequest $request)
    {
        $this->paymentmethodattr->create($request->all());

        return redirect()->route('admin.customer.paymentmethodattr.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('customer::paymentmethodattrs.title.paymentmethodattrs')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PaymentMethodAttr $paymentmethodattr
     * @return Response
     */
    public function edit(PaymentMethodAttr $paymentmethodattr)
    {
        return view('customer::admin.paymentmethodattrs.edit', compact('paymentmethodattr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PaymentMethodAttr $paymentmethodattr
     * @param  UpdatePaymentMethodAttrRequest $request
     * @return Response
     */
    public function update(PaymentMethodAttr $paymentmethodattr, UpdatePaymentMethodAttrRequest $request)
    {
        $this->paymentmethodattr->update($paymentmethodattr, $request->all());

        return redirect()->route('admin.customer.paymentmethodattr.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('customer::paymentmethodattrs.title.paymentmethodattrs')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PaymentMethodAttr $paymentmethodattr
     * @return Response
     */
    public function destroy(PaymentMethodAttr $paymentmethodattr)
    {
        $this->paymentmethodattr->destroy($paymentmethodattr);

        return redirect()->route('admin.customer.paymentmethodattr.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('customer::paymentmethodattrs.title.paymentmethodattrs')]));
    }
}
