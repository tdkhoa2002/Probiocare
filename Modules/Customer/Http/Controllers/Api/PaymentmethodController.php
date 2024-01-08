<?php

namespace Modules\Customer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Customer\Entities\Paymentmethod;
use Modules\Customer\Http\Requests\CreatePaymentMethodRequest;
use Modules\Customer\Http\Requests\UpdatePaymentMethodRequest;
use Modules\Customer\Repositories\PaymentMethodRepository;
use Modules\Customer\Transformers\Paymentmethods\FullPaymentmethodTransformer;
use Modules\Customer\Transformers\Paymentmethods\PaymentmethodTransformer;

class PaymentmethodController extends Controller
{
    /**
     * @var PaymentmethodRepository
     */
    private $paymentmethodRepository;

    public function __construct(PaymentmethodRepository $paymentmethodRepository)
    {
        $this->paymentmethodRepository = $paymentmethodRepository;
    }

    public function all()
    {
        return FullPaymentmethodTransformer::collection($this->paymentmethodRepository->all());
    }

    public function indexServerSide(Request $request)
    {
        return PaymentmethodTransformer::collection($this->paymentmethodRepository->serverPaginationFilteringFor($request));
    }

    public function store(CreatePaymentMethodRequest $request)
    {
        $this->paymentmethodRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('customer::paymentmethods.messages.paymentmethod created'),
        ]);
    }

    public function find($PaymentmethodId)
    {
        $Paymentmethod = $this->paymentmethodRepository->find($PaymentmethodId);
        return new FullPaymentmethodTransformer($Paymentmethod);
    }

    public function update(Paymentmethod $Paymentmethod, UpdatePaymentMethodRequest $request)
    {
        $this->paymentmethodRepository->update($Paymentmethod, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('customer::paymentmethods.messages.paymentmethod updated'),
        ]);
    }

    public function destroy(Paymentmethod $Paymentmethod)
    {
        $this->paymentmethodRepository->destroy($Paymentmethod);
        return response()->json([
            'errors' => false,
            'message' => trans('customer::paymentmethods.messages.paymentmethod deleted'),
        ]);
    }
}
