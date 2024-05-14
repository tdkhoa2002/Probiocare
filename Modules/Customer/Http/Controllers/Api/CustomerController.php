<?php

namespace Modules\Customer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Http\Requests\CreateCustomerRequest;
use Modules\Customer\Http\Requests\UpdateCustomerRequest;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Transformers\Customers\FullCustomerTransformer;
use Modules\Customer\Transformers\Customers\CustomerTransformer;
use Modules\Customer\Transformers\Customers\SmallCustomerTransformer;

class CustomerController extends Controller
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    public function __construct(CustomerRepository $CustomerRepository)
    {
        $this->customerRepository = $CustomerRepository;
    }

    public function all()
    {
        return FullCustomerTransformer::collection($this->customerRepository->all());
    }

    public function allWithFilter(Request $request)
    {
        $data = $request->all();
        $customers = $this->customerRepository->where('status', true);
        if (isset($data['query']) && $data['query'] != null) {
            $customers->where('email', 'LIKE', '%' . $data['query'] . '%');
        }
        if (isset($data['id']) && $data['id'] != null) {
            $customers->where('id', $data['id']);
        }
        $customers = $customers->get();
        return SmallCustomerTransformer::collection($customers);
    }

    public function indexServerSide(Request $request)
    {
        return CustomerTransformer::collection($this->customerRepository->serverPaginationFilteringFor($request));
    }

    public function store(CreateCustomerRequest $request)
    {
        $this->customerRepository->createAdmin($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('customer::customers.messages.customer created'),
        ]);
    }

    public function find($CustomerId)
    {
        $Customer = $this->customerRepository->find($CustomerId);
        return new FullCustomerTransformer($Customer);
    }

    public function update(Customer $Customer, UpdateCustomerRequest $request)
    {
        $this->customerRepository->update($Customer, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('customer::customers.messages.customer updated'),
        ]);
    }

    public function destroy(Customer $Customer)
    {
        $this->customerRepository->destroy($Customer);
        return response()->json([
            'errors' => false,
            'message' => trans('customer::customers.messages.customer deleted'),
        ]);
    }
}
