<?php

namespace Modules\Customer\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Customer\Enums\TypeEmailEnum;
use Modules\Customer\Http\Requests\FrontEnd\HanldeLoginRequest;
use Modules\Customer\Http\Requests\FrontEnd\LoginRequest;
use Modules\Customer\Jobs\JobSendCodeRegister;
use Modules\Customer\Jobs\JobSendEmailCodeLogin;
use Modules\Customer\Repositories\CountryRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Repositories\CustomerCodeRepository;

class ApiLoginController extends BaseApiController
{
    /**
     * @var Application
     */

    private $customerRepository;
    private $customerCodeRepository;


    public function __construct(
        CustomerRepository $customerRepository,
        CustomerCodeRepository $customerCodeRepository
    ) {
        parent::__construct();
        $this->customerRepository = $customerRepository;
        $this->customerCodeRepository = $customerCodeRepository;
    }


    public function postLogin(LoginRequest $request)
    {
        try {
            $dataRequest = $request->all();
            $customer = $this->customerRepository->findByAttributes(['email' => $dataRequest["email"]]);

            if ($customer->status == false) {
                JobSendCodeRegister::dispatch($customer);
                return $this->respondWithError(trans('customer::customers.messages.send_email_verify_register_success'));
            } else {
                if (Hash::check($dataRequest['password'], $customer->password)) {
                    $isEmail = true;
                    if ($customer->status_gg_auth == 2) {
                        $isEmail = false;
                    }
                    // if ($isEmail) {
                    //     JobSendEmailCodeLogin::dispatch($customer);
                    // }
                    // return $this->respondWithSuccess(['message' => trans('customer::customers.messages.send_email_code_login_success'), 'isEmail' => $isEmail]);
                    auth()->guard('customer')->login($customer);
                    return $this->respondWithSuccess(['message' => trans('customer::customers.messages.login_success'), 'url' => route('fe.wallet.wallet.list')]);
                } else {
                    return $this->respondWithError(trans('customer::customers.messages.email_or_password_wrong'));
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('customer::customers.messages.email_or_password_wrong'));
        }
    }


    public function hanldeLogin(HanldeLoginRequest $request)
    {
        try {
            $dataRequest = $request->all();
            $customer = $this->customerRepository->findByAttributes(['email' => $dataRequest["email"]]);
            if ($customer->status == false) {
                return $this->respondWithError(trans('customer::customers.messages.customer_not_active'));
            } else {
                auth()->guard('customer')->login($customer);
                return $this->respondWithSuccess(['message' => trans('customer::customers.messages.login_success'), 'url' => route('fe.wallet.wallet.list')]);
                // $code = $this->customerCodeRepository->findByAttributes(
                //     [
                //         'customer_id' => $customer->id,
                //         'code' => $request->get('code'),
                //         'type' => TypeEmailEnum::LOGIN
                //     ]
                // );
                // if ($code) {
                //     $now = now();
                //     $expired_at = Carbon::parse($code->expired_at);
                //     DB::table('customer__customercodes')
                //         ->where('type', TypeEmailEnum::LOGIN)
                //         ->where('customer_id', $customer->id)
                //         ->delete();
                //     if ($now > $expired_at) {
                //         return $this->respondWithError(trans('customer::customers.messages.verify_code_expired'));
                //     } else {
                //         auth()->guard('customer')->login($customer);
                //         return $this->respondWithSuccess(['message' => trans('customer::customers.messages.login_success'), 'url' => route('fe.wallet.wallet.list')]);
                //     }
                // } else {
                //     return $this->respondWithError(trans('customer::customers.messages.verify_code_expired'));
                // }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('customer::customers.messages.verify_code_expired'));
        }
    }
}
