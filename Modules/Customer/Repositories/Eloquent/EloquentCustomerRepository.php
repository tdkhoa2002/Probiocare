<?php

namespace Modules\Customer\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Customer\Repositories\CustomerProfileRepository;

class EloquentCustomerRepository extends EloquentBaseRepository implements CustomerRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $customers = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $customers->whereHas('profile', function ($query) use ($term) {
                $query->where('firstname', 'LIKE', "%{$term}%")->orWhere('lastname', 'LIKE', "%{$term}%");
            })->orWhere('email',  "%{$term}%")->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            if (\Str::contains($request->get('order_by'), '.')) {
                $fields = explode('.', $request->get('order_by'));

                $customers->with('profile')->join('customer__customerprofiles as t', function ($join) {
                    $join->on('customer__customers.id', '=', 't.customer_id  ');
                })->groupBy('customer__customers.id')->orderBy("t.{$fields[1]}", $order);
            } else {
                $customers->orderBy($request->get('order_by'), $order);
            }
        }

        return $customers->paginate($request->get('per_page', 10));
    }

    public function createAdmin($data)
    {
        if ($data['ref_code'] == null) {
            $data['ref_code'] = random_strings(10);
        }
        if ($data['password'] != null) {
            $data['password'] = Hash::make($data['password']);
        }
        $data['gg_auth'] = null;
        $data['status_gg_auth'] = 0;
        $data['status_kyc'] = 0;
        $data['email'] = strtolower($data['email']);
        $customer = $this->model->create($data);
        if ($customer) {
            $profile = $data['profile'];
            $dataProfile['customer_id'] = $customer->id;
            $dataProfile['firstname'] = $profile['firstname'];
            $dataProfile['lastname'] = $profile['lastname'];
            $dataProfile['phone_number'] = $profile['phone_number'] ?? null;
            $dataProfile['country_id'] = $profile['country_id'] ?? null;
            $dataProfile['address'] = $profile['address'] ?? null;
            $dataProfile['birthday'] = $profile['birthday'] ?? null;
            app(CustomerProfileRepository::class)->create($dataProfile);
        }
        return  $customer;
    }

    public function create($data)
    {
        if ($data['ref_code'] == null) {
            $data['ref_code'] = random_strings(10);
        }
        if ($data['password'] != null) {
            $data['password'] = Hash::make($data['password']);
        }
        $data['gg_auth'] = null;
        $data['status_gg_auth'] = 0;
        $data['status_kyc'] = 0;
        $data['email'] = strtolower($data['email']);
        $customer = $this->model->create($data);
        if ($customer) {
            $dataProfile['customer_id'] = $customer->id;
            $dataProfile['firstname'] = $data['firstname'];
            $dataProfile['lastname'] = $data['lastname'];
            $dataProfile['phone_number'] = $data['phone_number'] ?? null;
            $dataProfile['country_id'] = $data['country_id'] ?? null;
            $dataProfile['address'] = $data['address'] ?? null;
            $dataProfile['birthday'] = $data['birthday'] ?? null;
            app(CustomerProfileRepository::class)->create($dataProfile);
        }
        return  $customer;
    }

    public function update($customer, $data)
    {
        $dataCustomer = $data;
        unset($dataCustomer['profile']);
        $customer->update($dataCustomer);
        if (isset($data['profile'])) {
            app(CustomerProfileRepository::class)->update($customer->profile, $data['profile']);
        }
        return  $customer;
    }

    public function getCustomerWithFloor($sponsor_floor)
    {
        return $this->allWithBuilder()->where('status', true)->where('sponsor_floor', '<=', $sponsor_floor)->get();
    }

    public function getCustomerDirectMember($sponsor_id) {
        return $this->allWithBuilder()->where('status', true)->where('sponsor_id', $sponsor_id)->get();
    }
}
