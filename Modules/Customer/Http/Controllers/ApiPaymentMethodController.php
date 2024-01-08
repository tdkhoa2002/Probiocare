<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Customer\Repositories\PaymentMethodRepository;
use Modules\Customer\Transformers\Paymentmethods\FrontEnd\PaymentmethodTransformer;
use Modules\Customer\Repositories\PaymentMethodCustomerAttrRepository;
use Modules\Customer\Repositories\PaymentMethodCustomerRepository;
use Modules\Customer\Transformers\PaymentmethodCustomers\FrontEnd\PaymentmethodCustomerTransformer;

class ApiPaymentMethodController extends BaseApiController
{
    private $paymentMethodRepository;
    private $paymentMethodCustomerAttrRepository;
    private $paymentMethodCustomerRepository;
    public function __construct(
        PaymentMethodRepository $paymentMethodRepository,
        PaymentMethodCustomerAttrRepository $paymentMethodCustomerAttrRepository,
        PaymentMethodCustomerRepository $paymentMethodCustomerRepository
    ) {
        parent::__construct();
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->paymentMethodCustomerAttrRepository = $paymentMethodCustomerAttrRepository;
        $this->paymentMethodCustomerRepository = $paymentMethodCustomerRepository;
    }

    public function findPaymentMethod($paymentMethodId)
    {
        try {
            $paymentMethod = $this->paymentMethodRepository->find($paymentMethodId);
            return $this->respondWithSuccess(new PaymentmethodTransformer($paymentMethod));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    private function validateForm($dataAttr)
    {
        $rule = [];
        $message = [];
    }

    public function submitPaymentMethod(Request $request)
    {
        try {
            $paymentMethod = $this->paymentMethodRepository->find($request->get("paymentMethodId"));
            if ($paymentMethod) {
                $customer = auth()->guard('customer')->user();
                $customerPaymentMethod = $this->paymentMethodCustomerRepository->create([
                    'paymentmethod_id' => $paymentMethod->id, 'customer_id' => $customer->id
                ]);
                if ($customerPaymentMethod) {
                    $attrs = $request->get('attrs');
                    foreach ($attrs as $attr) {
                        $d = [
                            'payment_attr_id' => $attr['id'],
                            'payment_customer_id' => $customerPaymentMethod->id,
                            'value' => $attr['value']
                        ];
                        $this->paymentMethodCustomerAttrRepository->create($d);
                    }
                    return $this->respondWithSuccess(['message' => trans("customer::paymentmethods.messages.payment_method_create_success"), 'url' => route('fe.p2p.market.center')]);
                } else {
                    return $this->respondWithError(trans("customer::paymentmethods.messages.payment_method_was_created"));
                }
            } else {
                return $this->respondWithError(trans("customer::paymentmethods.messages.paymentmethod_not_found"));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function listMyPaymentMethod(Request $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            if ($request->has('customer_id')) {
                $customer_id = $request->get('customer_id');
            } else {
                $customer_id = $customer->id;
            }
            $myPaymentMethods = $this->paymentMethodCustomerRepository->getByAttributes(['customer_id' => $customer_id]);
            return $this->respondWithSuccess(PaymentmethodCustomerTransformer::collection($myPaymentMethods));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function findMyPaymentMethod($id)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $myPaymentMethod = $this->paymentMethodCustomerRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $id]);
            if ($myPaymentMethod) {
                return $this->respondWithSuccess(new PaymentmethodCustomerTransformer($myPaymentMethod));
            } else {
                return $this->respondWithError(trans("customer::paymentmethods.messages.paymentmethod_not_found"));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function updatePaymentMethod($id, Request $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $myPaymentMethod = $this->paymentMethodCustomerRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $id]);
            if ($myPaymentMethod) {
                $attrs = $request->get('attrs');
                foreach ($attrs as $attr) {
                    $customerPaymentAttr = $this->paymentMethodCustomerAttrRepository->findByAttributes(['payment_attr_id' => $attr['id'], 'payment_customer_id' => $myPaymentMethod->id]);
                    if ($customerPaymentAttr) {
                        $this->paymentMethodCustomerAttrRepository->update($customerPaymentAttr, ['value' => $attr['value']]);
                    } else {
                        $d = [
                            'payment_attr_id' => $attr['id'],
                            'payment_customer_id' => $myPaymentMethod->id,
                            'value' => $attr['value']
                        ];
                        $this->paymentMethodCustomerAttrRepository->create($d);
                    }
                }
                return $this->respondWithSuccess(['message' => trans("customer::paymentmethods.messages.payment_method_update_success")]);
            } else {
                return $this->respondWithError(trans("customer::paymentmethods.messages.paymentmethod_not_found"));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function deletePaymentMethod()
    {
    }
}
