<?php

namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Entities\PaymentMethodCustomer;
use Modules\Customer\Http\Requests\CreatePaymentMethodCustomerRequest;
use Modules\Customer\Http\Requests\UpdatePaymentMethodCustomerRequest;
use Modules\Customer\Repositories\PaymentMethodCustomerRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PaymentMethodCustomerController extends AdminBaseController
{
    /**
     * @var PaymentMethodCustomerRepository
     */
    private $paymentmethodcustomer;

    public function __construct(PaymentMethodCustomerRepository $paymentmethodcustomer)
    {
        parent::__construct();

        $this->paymentmethodcustomer = $paymentmethodcustomer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$paymentmethodcustomers = $this->paymentmethodcustomer->all();

        return view('customer::admin.paymentmethodcustomers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer::admin.paymentmethodcustomers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePaymentMethodCustomerRequest $request
     * @return Response
     */
    public function store(CreatePaymentMethodCustomerRequest $request)
    {
        $this->paymentmethodcustomer->create($request->all());

        return redirect()->route('admin.customer.paymentmethodcustomer.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('customer::paymentmethodcustomers.title.paymentmethodcustomers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PaymentMethodCustomer $paymentmethodcustomer
     * @return Response
     */
    public function edit(PaymentMethodCustomer $paymentmethodcustomer)
    {
        return view('customer::admin.paymentmethodcustomers.edit', compact('paymentmethodcustomer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PaymentMethodCustomer $paymentmethodcustomer
     * @param  UpdatePaymentMethodCustomerRequest $request
     * @return Response
     */
    public function update(PaymentMethodCustomer $paymentmethodcustomer, UpdatePaymentMethodCustomerRequest $request)
    {
        $this->paymentmethodcustomer->update($paymentmethodcustomer, $request->all());

        return redirect()->route('admin.customer.paymentmethodcustomer.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('customer::paymentmethodcustomers.title.paymentmethodcustomers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PaymentMethodCustomer $paymentmethodcustomer
     * @return Response
     */
    public function destroy(PaymentMethodCustomer $paymentmethodcustomer)
    {
        $this->paymentmethodcustomer->destroy($paymentmethodcustomer);

        return redirect()->route('admin.customer.paymentmethodcustomer.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('customer::paymentmethodcustomers.title.paymentmethodcustomers')]));
    }
}
