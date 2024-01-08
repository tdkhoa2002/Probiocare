<?php

namespace Modules\Customer\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Customer\Enums\TypeEmailEnum;
use Modules\Customer\Enums\TypeCustomerEnum;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Customer\Http\Requests\FrontEnd\RegisterRequest;
use Modules\Customer\Http\Requests\FrontEnd\ResendVerifyRegisterRequest;
use Modules\Customer\Http\Requests\FrontEnd\VerifyRegisterRequest;
use Modules\Customer\Http\Requests\FrontEnd\LoginRequest;
use Modules\Customer\Jobs\JobSendCodeRegister;
use Modules\Customer\Jobs\JobSendVerifiedCodeSuccess;
use Modules\Customer\Repositories\CountryRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Repositories\CustomerCodeRepository;

class PublicController extends BasePublicController
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

    public function login()
    {
        try {
            return view('auths.signin');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
    public function register()
    {
        try {
            return view('auths.signup');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
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

    public function forgotPassword(LoginRequest $request)
    {
        try {
            $dataRequest = $request->all();
            $customer = $this->customerRepository->findByAttributes(['email' =>  $dataRequest["email"]]);
            if ($customer->status == false) {
                return back()->withErrors(trans('customer::customers.messages.customer_not_active'));
            } else {
                if (Hash::check($dataRequest['password'], $customer->password)) {
                    $isEmail = true;
                    if ($customer->status_gg_auth == 2) {
                        $isEmail = false;
                    }
                    return redirect()->route('fe.customer.customer.verifyLogin', ['isEmail' => $isEmail]);
                } else {
                    return back()->withErrors(trans('customer::customers.messages.email_or_password_wrong'))->withInput();
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
    public function postLogin(LoginRequest $request)
    {
        try {
            $dataRequest = $request->all();
            $customer = $this->customerRepository->findByAttributes(['email' =>  $dataRequest["email"]]);
            if ($customer->status == false) {
                return back()->withErrors(trans('customer::customers.messages.customer_not_active'));
            } else {
                if (Hash::check($dataRequest['password'], $customer->password)) {
                    $isEmail = true;
                    if ($customer->status_gg_auth == 2) {
                        $isEmail = false;
                    }
                    return redirect()->route('fe.customer.customer.verifyLogin', ['isEmail' => $isEmail]);
                } else {
                    return back()->withErrors(trans('customer::customers.messages.email_or_password_wrong'))->withInput();
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function verifyLogin()
    {
        try {
            return view('auths.verify-login');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
    
    public function postRegister(RegisterRequest $request)
    {
        try {
            $dataRequest = $request->all();
            // dd($dataRequest);
            if ($dataRequest['password'] !== $dataRequest['password-confirm']) {
                return back()->withErrors(trans('customer::customers.messages.password_confirm_not_match'));
            }
            unset($dataRequest['password-confirm']);

            $country = $this->countryRepository->find($dataRequest['country_id']);

            if (!$country) {
                return back()->withErrors(trans('customer::countries.not_found'));
            }

            $sponsor = null;
            if (isset($dataRequest['sponsor_key'])) {
                $sponsor =  $this->customerRepository->findByAttributes(['ref_code' => $dataRequest['sponsor_key']]);
                if (!$sponsor) {
                    return back()->withErrors(trans('customer::customers.sponsor_not_found'));
                }
            }

            if ($sponsor) {
                $dataRequest['sponsor_id'] = $sponsor->id;
                $dataRequest['sponsor_floor'] = $sponsor->sponsor_floor;
            }

            $dataRequest['ref_code'] = null;
            $dataRequest['status'] = TypeCustomerEnum::NEW_CUSTOMER;

            $customer = $this->customerRepository->create($dataRequest);
            JobSendCodeRegister::dispatch($customer);
            return redirect('/signin')->withSuccess(trans('customer::customers.messages.created'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function resendVerifyRegister(ResendVerifyRegisterRequest $request)
    {
        try {
            $email = $request->get('email');
            $customer = $this->customerRepository->findByAttributes(['email' => $email, 'status' => false]);
            if ($customer) {
                $code = $this->customerCodeRepository->findByAttributes(['customer_id' => $customer->id, 'type' => TypeEmailEnum::REGISTER]);
                if ($code) {
                    $now = now();
                    $createdAt = Carbon::parse($code->created_at)->addMinute(1);
                    if ($now > $createdAt) {
                        $this->customerCodeRepository->destroy($code);
                        JobSendCodeRegister::dispatch($customer);
                        return back()->withSuccess(trans('customer::customers.messages.resend_email_success'));
                    } else {
                        return back()->withErrors(trans('customer::customers.messages.err_request_too_often'));
                    }
                } else {
                    JobSendCodeRegister::dispatch($customer);
                    return back()->withSuccess(trans('customer::customers.messages.resend_email_success'));
                }
            } else {
                return back()->withErrors(trans('customer::customers.messages.email_wrong_not_esxit'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function verifyRegister(VerifyRegisterRequest $request)
    {
        try {
            $email = $request->get('email');
            $customer = $this->customerRepository->findByAttributes(['email' => $email, 'status' => false]);
            if ($customer) {
                $code = $this->customerCodeRepository->findByAttributes([
                    'customer_id' => $customer->id,
                    'type' => TypeEmailEnum::REGISTER,
                    'code' => $request->get('code')
                ]);
                if ($code) {
                    $now = now();
                    $expired_at = Carbon::parse($code->expired_at);
                    if ($now > $expired_at) {
                        $this->customerCodeRepository->destroy($code);
                        JobSendCodeRegister::dispatch($customer);
                        return back()->withErrors(trans('customer::customers.messages.verify_code_expire_please_check_your_email'));
                    } else {
                        $this->customerCodeRepository->destroy($code);
                        $this->customerRepository->update($customer, ['status' => TypeCustomerEnum::EMAIL_VERIFIED]);
                        // JobSendVerifiedCodeSuccess::dispatch($customer);
                        return redirect('/signin')->withSuccess(trans('customer::customers.messages.active_account_success'));
                    }
                } else {
                    return back()->withErrors(trans('customer::customers.messages.verify_code_wrong'));
                }
            } else {
                return back()->withErrors(trans('customer::customers.messages.email_wrong_not_esxit'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
