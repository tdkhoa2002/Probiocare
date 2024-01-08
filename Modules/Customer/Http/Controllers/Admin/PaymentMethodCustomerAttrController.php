<?php

namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Entities\PaymentMethodCustomerAttr;
use Modules\Customer\Http\Requests\CreatePaymentMethodCustomerAttrRequest;
use Modules\Customer\Http\Requests\UpdatePaymentMethodCustomerAttrRequest;
use Modules\Customer\Repositories\PaymentMethodCustomerAttrRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PaymentMethodCustomerAttrController extends AdminBaseController
{
    /**
     * @var PaymentMethodCustomerAttrRepository
     */
    private $paymentmethodcustomerattr;

    public function __construct(PaymentMethodCustomerAttrRepository $paymentmethodcustomerattr)
    {
        parent::__construct();

        $this->paymentmethodcustomerattr = $paymentmethodcustomerattr;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$paymentmethodcustomerattrs = $this->paymentmethodcustomerattr->all();

        return view('customer::admin.paymentmethodcustomerattrs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer::admin.paymentmethodcustomerattrs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePaymentMethodCustomerAttrRequest $request
     * @return Response
     */
    public function store(CreatePaymentMethodCustomerAttrRequest $request)
    {
        $this->paymentmethodcustomerattr->create($request->all());

        return redirect()->route('admin.customer.paymentmethodcustomerattr.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('customer::paymentmethodcustomerattrs.title.paymentmethodcustomerattrs')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PaymentMethodCustomerAttr $paymentmethodcustomerattr
     * @return Response
     */
    public function edit(PaymentMethodCustomerAttr $paymentmethodcustomerattr)
    {
        return view('customer::admin.paymentmethodcustomerattrs.edit', compact('paymentmethodcustomerattr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PaymentMethodCustomerAttr $paymentmethodcustomerattr
     * @param  UpdatePaymentMethodCustomerAttrRequest $request
     * @return Response
     */
    public function update(PaymentMethodCustomerAttr $paymentmethodcustomerattr, UpdatePaymentMethodCustomerAttrRequest $request)
    {
        $this->paymentmethodcustomerattr->update($paymentmethodcustomerattr, $request->all());

        return redirect()->route('admin.customer.paymentmethodcustomerattr.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('customer::paymentmethodcustomerattrs.title.paymentmethodcustomerattrs')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PaymentMethodCustomerAttr $paymentmethodcustomerattr
     * @return Response
     */
    public function destroy(PaymentMethodCustomerAttr $paymentmethodcustomerattr)
    {
        $this->paymentmethodcustomerattr->destroy($paymentmethodcustomerattr);

        return redirect()->route('admin.customer.paymentmethodcustomerattr.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('customer::paymentmethodcustomerattrs.title.paymentmethodcustomerattrs')]));
    }
}
