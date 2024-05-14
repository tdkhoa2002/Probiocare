<?php

namespace Modules\Customer\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Customer\Emails\SendForgotPassword;
use Modules\Customer\Enums\TypeEmailEnum;
use Modules\Customer\Http\Requests\FrontEnd\ChangePasswordRequest;
use Modules\Customer\Http\Requests\FrontEnd\ForgotPasswordRequest;
use Modules\Customer\Jobs\JobSendLinkForgotPassword;
use Modules\Customer\Repositories\CountryRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Repositories\CustomerCodeRepository;

class ForgotController extends BasePublicController
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

    public function forgot()
    {
        try {
            return view('auths.forgot');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $dataRequest = $request->all();
            $customer = $this->customerRepository->findByAttributes(['email' => $dataRequest["email"]]);
            if ($customer) {
                if ($customer->status == false) {
                    return back()->withErrors(trans('customer::customers.messages.customer_not_active'));
                } else {
                    JobSendLinkForgotPassword::dispatch($customer);
                    return redirect()->route('fe.customer.customer.verifyForgot', ['email' => $customer->email])
                        ->withSuccess(trans('customer::customers.messages.send_email_forgot_success'));
                }
            } else {
                return back()->withErrors(trans('customer::customers.messages.customer_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function verifyForgot(Request $request)
    {
        try {
            $dataRequest = $request->all();
            $token = $dataRequest['token'] ?? "";
            $email = $dataRequest['email'] ?? "";
            $customer = $this->customerRepository->findByAttributes(['email' => $email]);
            if ($customer) {
                return view('auths.new-password', ['token' => $token, 'email' => $email]);
            } else {
                return back()->withErrors(trans('customer::customers.messages.customer_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $customer = $this->customerRepository->findByAttributes(['email' => $request->get('email')]);
            if ($customer) {
                $code = $this->customerCodeRepository->findByAttributes(
                    [
                        'customer_id' => $customer->id,
                        'code' => $request->get('code'),
                        'type' => TypeEmailEnum::FORGOTPASSWORD
                    ]
                );
                if ($code) {
                    $now = now();
                    $expired_at = Carbon::parse($code->expired_at);
                    DB::table('customer__customercodes')
                    ->where('type', TypeEmailEnum::FORGOTPASSWORD)
                    ->where('customer_id', $customer->id)
                    ->delete();
                    if ($now > $expired_at) {
                        return redirect()->route('fe.customer.customer.forgot')->withErrors(trans('customer::customers.messages.verify_code_expired'));
                    } else {
                        $this->customerRepository->update($customer, ['password' => Hash::make($request->get('password'))]);
                        return redirect()->route('fe.customer.customer.login')->withSuccess(trans('customer::customers.messages.change_password_success'));
                    }
                } else {
                    return back()->withErrors(trans('customer::customers.messages.verify_code_expired'));
                }
            } else {
                return back()->withErrors(trans('customer::customers.messages.customer_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
