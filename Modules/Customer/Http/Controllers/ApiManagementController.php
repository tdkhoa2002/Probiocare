<?php

namespace Modules\Customer\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Repositories\CustomerApiKeyRepository;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Core\Http\Controllers\BasePublicController;

class ApiManagementController extends BasePublicController
{
    private $customerApiKey;

    public function __construct(CustomerApiKeyRepository $customerApiKey) {
        $this->customerApiKey = $customerApiKey;
    }

    public function create(Request $request) {
        try {
            $customer = auth()->guard('customer')->user();
            $apiToken = Str::uuid()->toString();
            $expiredAt = Carbon::now()->addDays(30);
            $this->customerApiKey->create([
                'title' => $request['title'],
                'customer_id' => $customer->id,
                'token' => $apiToken,
                'expired_at' => $expiredAt
            ]);
            return back()->withSuccess(trans('customer::customerapitoken.messages.api_token_created'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500);
        }
    }

    public function delete(Request $request) {
        try {
            $requestData = $request->all();
            $api = $this->customerApiKey->findByAttributes(['token' => $requestData['token']]);
            $this->customerApiKey->destroy($api);
            return back()->withSuccess(trans('customer::customerapitoken.messages.api_token_deleted'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500);
        }
    }
}
