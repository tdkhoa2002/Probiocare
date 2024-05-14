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
use Modules\Customer\Http\Requests\FrontEnd\RequestKycRequest;
use Modules\Customer\Jobs\JobSendCodeChangePassword;
use Modules\Customer\Jobs\JobSendLinkForgotPassword;
use Modules\Customer\Repositories\CountryRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Repositories\CustomerCodeRepository;

class KycController extends BasePublicController
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
    public function getKyc()
    {
        try {
            $customer = auth()->guard('customer')->user();
            if ($customer->status_kyc == 0 || $customer->status_kyc == 3) {
                return view('my-accounts.kyc',  compact('customer'));
            } else {
                return back();
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
