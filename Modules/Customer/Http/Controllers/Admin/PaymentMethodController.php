<?php

namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Customer\Entities\PaymentMethod;
use Modules\Customer\Http\Requests\CreatePaymentMethodRequest;
use Modules\Customer\Http\Requests\UpdatePaymentMethodRequest;
use Modules\Customer\Repositories\PaymentMethodRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PaymentMethodController extends AdminBaseController
{
    /**
     * @var PaymentMethodRepository
     */
    private $paymentmethod;

    public function __construct(PaymentMethodRepository $paymentmethod)
    {
        parent::__construct();

        $this->paymentmethod = $paymentmethod;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('customer::admin.paymentmethods.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('customer::admin.paymentmethods.create');
    }

    public function edit(PaymentMethod $paymentmethod)
    {
        return view('customer::admin.paymentmethods.edit', compact('paymentmethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PaymentMethod $paymentmethod
     * @param  UpdatePaymentMethodRequest $request
     * @return Response
     */
    public function update(PaymentMethod $paymentmethod, UpdatePaymentMethodRequest $request)
    {
        $this->paymentmethod->update($paymentmethod, $request->all());

        return redirect()->route('admin.customer.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('customer::paymentmethods.title.paymentmethods')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PaymentMethod $paymentmethod
     * @return Response
     */
    public function destroy(PaymentMethod $paymentmethod)
    {
        $this->paymentmethod->destroy($paymentmethod);

        return redirect()->route('admin.customer.paymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('customer::paymentmethods.title.paymentmethods')]));
    }
}
