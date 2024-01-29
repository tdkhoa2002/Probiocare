<?php

namespace Modules\Customer\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

class RegisterController extends BasePublicController
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


    public function register(Request $request)
    {
        try {
            $ref_code = isset($request->ref) ? $request->ref : "";
            if (auth()->guard('customer')->check()) {
                return redirect()->route('fe.wallet.wallet.list');
            }
            return view('auths.signup', compact('ref_code'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function postRegister(RegisterRequest $request)
    {
        try {
            $dataRequest = $request->all();
            $country = $this->countryRepository->find($dataRequest['country_id']);
            if (!$country) {
                return back()->withErrors(trans('customer::countries.not_found'));
            }

            $sponsor = null;
            if (isset($dataRequest['ref_code'])) {
                $sponsor =  $this->customerRepository->findByAttributes(['ref_code' => $dataRequest['ref_code']]);
                if (!$sponsor) {
                    return back()->withErrors(trans('customer::customers.messages.sponsor_not_found'))->withInput();
                }
            }

            if ($sponsor == null) {
                $sponsor = $this->customerRepository->find(setting('customer::id_ref_top'));
            }

            if ($sponsor) {
                $dataRequest['sponsor_id'] = $sponsor->id;
                $dataRequest['sponsor_floor'] = $sponsor->sponsor_floor + 1;
            }

            $dataRequest['ref_code'] = null;
            $dataRequest['status'] = TypeCustomerEnum::NEW_CUSTOMER;

            $customer = $this->customerRepository->create($dataRequest);
            JobSendCodeRegister::dispatch($customer);
            return redirect()->route('fe.customer.customer.verifyRegister', ['email' => $dataRequest['email']])
                ->withSuccess(trans('customer::customers.messages.send_email_verify_register_success'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            abort(500);
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
                        return response()->json([
                            'errors' => false,
                            'message' => trans('customer::customers.messages.resend_email_success'),
                        ]);
                    } else {
                        return response()->json([
                            'errors' => true,
                            'message' => trans('customer::customers.messages.err_request_too_often'),
                        ]);
                    }
                } else {
                    JobSendCodeRegister::dispatch($customer);
                    return response()->json([
                        'errors' => false,
                        'message' => trans('customer::customers.messages.resend_email_success'),
                    ]);
                }
            } else {
                return response()->json([
                    'errors' => true,
                    'message' => trans('customer::customers.messages.email_wrong_not_esxit'),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function verifyRegister(Request $request)
    {
        try {
            $email = $request->get('email');
            $customer = $this->customerRepository->findByAttributes(['email' => $email, 'status' => false]);
            if ($customer) {
                return view('auths.verify-register', ['email' => $email]);
            } else {
                return back()->withErrors(trans('customer::customers.messages.email_wrong_not_esxit'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function handleVerifyRegister(VerifyRegisterRequest $request)
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
                    DB::table('customer__customercodes')
                        ->where('type', TypeEmailEnum::REGISTER)
                        ->where('customer_id', $customer->id)
                        ->delete();
                    if ($now > $expired_at) {
                        JobSendCodeRegister::dispatch($customer);
                        return back()->withErrors(trans('customer::customers.messages.verify_code_expire_please_check_your_email'));
                    } else {
                        $this->customerRepository->update($customer, ['status' => TypeCustomerEnum::EMAIL_VERIFIED]);
                        JobSendVerifiedCodeSuccess::dispatch($customer);
                        auth()->guard('customer')->login($customer);
                        return redirect()->route('fe.wallet.wallet.list')->withSuccess(trans('customer::customers.messages.login_success'));

                        // return redirect()->route('fe.customer.customer.login')->withSuccess(trans('customer::customers.messages.active_account_success'));
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
