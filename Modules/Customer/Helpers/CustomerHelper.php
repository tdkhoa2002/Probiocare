<?php

namespace Modules\Customer\Helpers;

use Modules\Customer\Repositories\CustomerRepository;

class CustomerHelper
{
    public static function getParentCustomer($customer)
    {
        $customerFloors = app(CustomerRepository::class)->getCustomerWithFloor($customer->sponsor_floor)->toArray();
        $data = [];
        $dataRecursive = self::recursiveParentCustomer($customerFloors, $customer->sponsor_id, 0, $data);
        $dataLevel0 = [
            "id" => $customer->id,
            "email" => $customer->email,
            "ref_code" => $customer->ref_code,
            "gg_auth" => $customer->gg_auth,
            "status_gg_auth" => $customer->status_gg_auth,
            "status_kyc" => $customer->status_kyc,
            "sponsor_id" => $customer->sponsor_id,
            "sponsor_floor" => $customer->sponsor_floor,
            "status" => $customer->status,
            "created_at" => $customer->created_at,
            "updated_at" => $customer->updated_at,
            "deleted_at" => null,
            "is_agent" => $customer->is_agent,
            "level" => 0,
        ];
        array_push($dataRecursive, $dataLevel0);
        return $dataRecursive;
    }

    private static function recursiveParentCustomer($customers, $sponsor_id, $level, &$data)
    {
        foreach ($customers as $customer) {
            if ($customer['id'] == $sponsor_id) {
                $customer['level'] = $level + 1;
                array_push($data, $customer);
                self::recursiveParentCustomer($customers, $customer['sponsor_id'], $customer['level'], $data);
            }
        }
        return $data;
    }
}
