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
use Modules\Customer\Http\Requests\FrontEnd\HanldeLoginRequest;
use Modules\Customer\Http\Requests\FrontEnd\RegisterRequest;
use Modules\Customer\Http\Requests\FrontEnd\ResendVerifyRegisterRequest;
use Modules\Customer\Http\Requests\FrontEnd\VerifyRegisterRequest;
use Modules\Customer\Http\Requests\FrontEnd\LoginRequest;
use Modules\Customer\Jobs\JobSendCodeRegister;
use Modules\Customer\Jobs\JobSendEmailCodeLogin;
use Modules\Customer\Jobs\JobSendVerifiedCodeSuccess;
use Modules\Customer\Repositories\CountryRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Repositories\CustomerProfileRepository;
use Modules\Customer\Repositories\CustomerCodeRepository;
use Modules\Customer\Repositories\CustomerApiKeyRepository;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Libraries\Web3Eth;

class ProfileController extends BasePublicController
{
    /**
     * @var Application
     */
    private $app;
    private $countryRepository;
    private $customerRepository;
    private $customerProfileRepository;
    private $customerCodeRepository;
    private $transactionRepository;
    private $customerApiKey;


    public function __construct(
        Application $app,
        CountryRepository $countryRepository,
        CustomerRepository $customerRepository,
        CustomerProfileRepository $customerProfileRepository,
        CustomerCodeRepository $customerCodeRepository,
        TransactionRepository $transactionRepository,
        CustomerApiKeyRepository $customerApiKey
    ) {
        parent::__construct();
        $this->app = $app;
        $this->countryRepository = $countryRepository;
        $this->customerRepository = $customerRepository;
        $this->customerProfileRepository = $customerProfileRepository;
        $this->customerCodeRepository = $customerCodeRepository;
        $this->transactionRepository = $transactionRepository;
        $this->customerApiKey = $customerApiKey;
    }

    public function index()
    {
        try {
            $countries = $this->countryRepository->all();
            return view('my-accounts.profile', compact('countries'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function getProfileEdit()
    {
        try {
            $countries = $this->countryRepository->all();
            return view('my-accounts.profile-edit', compact('countries'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $dataRequest = $request->all();
            $customer = auth()->guard('customer')->user();
            $country = $this->countryRepository->find($dataRequest['country_id']);
            if (!$country) {
                return back()->withErrors(trans('customer::countries.not_found'));
            }

            if ($customer->status == false) {
                return back()->withErrors(trans('customer::customers.message.customer_not_active'));
            } else {
                $profile = $customer->profile;
                $data = [
                    'firstname' => $dataRequest['firstname'],
                    'lastname' => $dataRequest['lastname'],
                    'country_id' => $dataRequest['country_id'],
                    'phone_number' => $dataRequest['phone_number'],
                    'address' => $dataRequest['address'],
                    'birthday' => $dataRequest['birthday']
                ];
                $this->customerProfileRepository->update($profile, $data);
                return redirect()
                    ->route('fe.customer.customer.account')
                    ->withSuccess(trans('customer::customers.message.update_profile_success'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function getSetting()
    {
        try {
            $customer = auth()->guard('customer')->user();
            $kyc = $customer->kyc;
            return view('my-accounts.setting', compact('customer', 'kyc'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function getActivities()
    {
        try {
            return view('my-accounts.activities');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
    public function affiliate()
    {
        try {
            $customer = auth()->guard('customer')->user();
            $actions = [
                TypeTransactionActionEnum::COMMISSION_STAKING,
                TypeTransactionActionEnum::TRADING_FEE_BONUS,
                TypeTransactionActionEnum::DEPOSIT_BONUS
            ];
            $transactions = $this->transactionRepository->getTxnsByAction($customer->id, $actions);
            $totalCommissionStaking = 0;
            $totalCommissionTrade = 0;
            $totalCommissionDeposit = 0;
            $totalDirectMember = 0;
            foreach ($transactions as $transaction) {
                if ($transaction->action === TypeTransactionActionEnum::COMMISSION_STAKING->value) {
                    $totalCommissionStaking = $transaction->total;
                } elseif ($transaction->action === TypeTransactionActionEnum::TRADING_FEE_BONUS->value) {
                    $totalCommissionTrade = $transaction->total;
                } elseif ($transaction->action === TypeTransactionActionEnum::DEPOSIT_BONUS->value) {
                    $totalCommissionDeposit = $transaction->total;
                }
            }
            $members = $this->customerRepository->getCustomerDirectMember($customer->id);
            $totalDirectMember = count($members);
            return view('my-accounts.affiliate', compact('customer', 'totalCommissionStaking', 'totalCommissionTrade', 'totalCommissionDeposit', 'totalDirectMember'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function logout(Request $request)
    {
        try {
            auth()->guard('customer')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('homepage');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function getApiKeys() {
        try {
            $customer = auth()->guard('customer')->user();
            $apis = $customer->apiTokens;
            return view('my-accounts.manage-apiKey', compact('apis'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
