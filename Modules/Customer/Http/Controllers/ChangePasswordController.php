<?php

namespace Modules\Customer\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Customer\Emails\SendForgotPassword;
use Modules\Customer\Enums\TypeEmailEnum;
use Modules\Customer\Http\Requests\FrontEnd\ChangePasswordRequest;
use Modules\Customer\Http\Requests\FrontEnd\ForgotPasswordRequest;
use Modules\Customer\Jobs\JobSendCodeChangePassword;
use Modules\Customer\Jobs\JobSendLinkForgotPassword;
use Modules\Customer\Repositories\CountryRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Repositories\CustomerCodeRepository;

class ChangePasswordController extends BaseApiController
{
    /**
     * @var Application
     */
    private $app;
    private $countryRepository;
    private $customerRepository;
    private $customerCodeRepository;


    public function __construct(
        Application $app,
        CountryRepository $countryRepository,
        CustomerRepository $customerRepository,
        CustomerCodeRepository $customerCodeRepository
    ) {
        parent::__construct();
        $this->app = $app;
        $this->countryRepository = $countryRepository;
        $this->customerRepository = $customerRepository;
        $this->customerCodeRepository = $customerCodeRepository;
    }

    public function sendCodeChangePassword()
    {
        try {
            $customer = auth()->guard('customer')->user();
            $checkCode = $this->customerCodeRepository->findByAttributes(['type' => TypeEmailEnum::CHANGEPASSWORD, 'customer_id' => $customer->id]);
            if ($checkCode) {
                $now = now();
                $expired_at = Carbon::parse($checkCode->expired_at);
                if ($now < $expired_at) {
                    return $this->respondWithSuccess(['message' => trans("customer::customercodes.messages.send_code_change_password_success")]);
                } else {
                    DB::table('customer__customercodes')
                        ->where('type', TypeEmailEnum::CHANGEPASSWORD)
                        ->where('customer_id', $customer->id)
                        ->delete();
                    JobSendCodeChangePassword::dispatch($customer);
                    return $this->respondWithSuccess(['message' => trans("customer::customercodes.messages.send_code_change_password_success")]);
                }
            } else {
                DB::table('customer__customercodes')
                    ->where('type', TypeEmailEnum::CHANGEPASSWORD)
                    ->where('customer_id', $customer->id)
                    ->delete();
                JobSendCodeChangePassword::dispatch($customer);
                return $this->respondWithSuccess(['message' => trans("customer::customercodes.messages.send_code_change_password_success")]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError('Send email error');
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $dataRequst = $request->all();
            if (!$dataRequst['confirmPassword'] || !$dataRequst['password'] || !$dataRequst['code']) {
                return $this->respondWithError(trans('customer::customers.messages.verify_code_expired'));
            }

            if (strlen($dataRequst['password']) < 8 ) {
                return $this->respondWithError(trans('customer::customers.messages.password_min_8_character'));
            }

            if ($dataRequst['confirmPassword'] != $dataRequst['password']) {
                return $this->respondWithError(trans('customer::customers.messages.confim_password_dont_match'));
            }

            $customer = auth()->guard('customer')->user();
            $code = $this->customerCodeRepository->findByAttributes(
                [
                    'customer_id' => $customer->id,
                    'code' => $request->get('code'),
                    'type' => TypeEmailEnum::CHANGEPASSWORD
                ]
            );
            if ($code) {
                $now = now();
                $expired_at = Carbon::parse($code->expired_at);
                DB::table('customer__customercodes')
                    ->where('type', TypeEmailEnum::CHANGEPASSWORD)
                    ->where('customer_id', $customer->id)
                    ->delete();
                if ($now > $expired_at) {
                    return $this->respondWithError(trans('customer::customers.messages.verify_code_expired'));
                } else {
                    $this->customerRepository->update($customer, ['password' => Hash::make($request->get('password'))]);
                    return $this->respondWithSuccess(['message' => trans('customer::customers.messages.change_password_success')]);
                }
            } else {
                return $this->respondWithError(trans('customer::customers.messages.verify_code_expired'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError('Send email error');
        }
    }
}
