<?php

namespace Modules\Customer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Http\Requests\CreateCustomerRequest;
use Modules\Customer\Http\Requests\UpdateCustomerRequest;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Repositories\CustomerKycRepository;
use Modules\Customer\Transformers\CustomerKycs\FullCustomerKycTransformer;

class CustomerKycController extends Controller
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;
    private $customerKycRepository;

    public function __construct(
        CustomerRepository $customerRepository,
        CustomerKycRepository $customerKycRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerKycRepository = $customerKycRepository;
    }

    public function find($customerId)
    {
        $customer = $this->customerRepository->find($customerId);
        if ($customer) {
            $kyc = $customer->kyc;
            if ($kyc) {
                return response()->json([
                    'errors' => false,
                    'kyc' => new FullCustomerKycTransformer($kyc),
                    'status_kyc' => $customer->status_kyc
                ]);
            } else {
                return response()->json([
                    'errors' => false,
                    'kyc' => null
                ]);
            }
        } else {
            return response()->json([
                'errors' => true,
                'message' => trans('customer::customers.messages.customer_not_found'),
            ]);
        }
    }

    public function update($customerId, Request $request)
    {
        $customer = $this->customerRepository->find($customerId);
        if ($customer) {
            $kyc = $customer->kyc;
            if ($kyc) {
                $dataRequest = $request->all();
                $currentStatus = $customer->status_kyc;
                if ($dataRequest['status_kyc'] !=   $currentStatus) {
                    $dataCustomer = ['status_kyc' => $dataRequest['status_kyc']];
                    if ($dataRequest['status_kyc'] == 2) {
                        $dataCustomer['profile'] = [
                            'firstname' => $kyc->first_name,
                            'lastname' => $kyc->last_name,
                            'country_id' => $kyc->country_id,
                            'birthday' => $kyc->birthday,
                        ];
                    }
                    $this->customerRepository->update($customer, $dataCustomer);
                }
                $this->customerKycRepository->update($kyc, ['reason' => $dataRequest['reason']]);
                return response()->json([
                    'errors' => false,
                    'message' => trans('customer::customerkycs.messages.kyc_updated'),
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'message' => trans('customer::customerkycs.messages.customer_kyc_not_found'),
                ]);
            }
        } else {
            return response()->json([
                'errors' => true,
                'message' => trans('customer::customers.messages.customer_not_found'),
            ]);
        }
    }
}
