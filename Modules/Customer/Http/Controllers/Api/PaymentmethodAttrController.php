<?php

namespace Modules\Customer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Customer\Entities\PaymentMethodAttr;
use Modules\Customer\Http\Requests\CreatePaymentMethodAttrRequest;
use Modules\Customer\Http\Requests\UpdatePaymentMethodAttrRequest;
use Modules\Customer\Repositories\PaymentMethodAttrRepository;
use Modules\Customer\Transformers\PaymentmethodAttrs\FullPaymentmethodAttrTransformer;
use Modules\Customer\Transformers\PaymentmethodAttrs\PaymentmethodAttrTransformer;

class PaymentmethodAttrController extends Controller
{
    /**
     * @var PaymentMethodAttrRepository
     */
    private $paymentMethodAttrRepository;

    public function __construct(PaymentMethodAttrRepository $paymentMethodAttrRepository)
    {
        $this->paymentMethodAttrRepository = $paymentMethodAttrRepository;
    }

    public function indexServerSide($paymentmethod_id)
    {
        return PaymentmethodAttrTransformer::collection($this->paymentMethodAttrRepository->getByAttributes(['paymentmethod_id' => $paymentmethod_id]));
    }

    public function store(CreatePaymentMethodAttrRequest $request)
    {
        $this->paymentMethodAttrRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('customer::paymentmethods.messages.paymentmethod created'),
        ]);
    }

    public function find($paymentmethodId,$paymentmethodAttrId)
    {
        $paymentmethodAttr = $this->paymentMethodAttrRepository->findByAttributes(['id'=>$paymentmethodAttrId,'paymentmethod_id'=>$paymentmethodId]);
        return new FullPaymentmethodAttrTransformer($paymentmethodAttr);
    }

    public function update($paymentmethodId,$paymentmethodAttrId, UpdatePaymentMethodAttrRequest $request)
    {
        $paymentmethodAttr = $this->paymentMethodAttrRepository->findByAttributes(['id'=>$paymentmethodAttrId,'paymentmethod_id'=>$paymentmethodId]);
        $this->paymentMethodAttrRepository->update($paymentmethodAttr, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('customer::paymentmethods.messages.paymentmethod updated'),
        ]);
    }

    public function destroy(PaymentMethodAttr $Paymentmethod)
    {
        $this->paymentMethodAttrRepository->destroy($Paymentmethod);
        return response()->json([
            'errors' => false,
            'message' => trans('customer::paymentmethods.messages.paymentmethod deleted'),
        ]);
    }
}
