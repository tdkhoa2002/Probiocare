<?php

namespace Modules\Peertopeer\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Peertopeer\Repositories\AdsRepository;
use Modules\Peertopeer\Http\Requests\UpdateAgentApplyRequest;
use Modules\Customer\Enums\TypeCustomerKYCEnum;
use Modules\Customer\Enums\TypeCustomerAgentEnum;
use Modules\Peertopeer\Jobs\JobSendBecomeAgentSuccess;
use Modules\Peertopeer\Repositories\OrderRepository;

class P2PAgentController extends BasePublicController
{
    /**
     * @var Application
     */
    private $app;
    private $adsRepository;
    private $customerRepository;
    private $orderRepository;


    public function __construct(
        Application $app,
        AdsRepository $adsRepository,
        CustomerRepository $customerRepository,
        OrderRepository $orderRepository
    ) {
        parent::__construct();
        $this->app = $app;
        $this->adsRepository = $adsRepository;
        $this->customerRepository = $customerRepository;
        $this->orderRepository = $orderRepository;
    }

    public function getAgent($agentID)
    {
        try {
            $agent = $this->customerRepository->findByAttributes(['is_agent' => true, 'id' => $agentID, 'status' => true]);
            if (!$agent) {
                return back();
            }
            return view('p2p.p2p-agent', compact('agent'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function postAgentApply(UpdateAgentApplyRequest $request)
    {
        try {
            $requestData = $request->all();
            $customer = auth()->guard('customer')->user();
            if ($customer->status_kyc == TypeCustomerKYCEnum::IS_NOT_KYC) {
                return back()->withErrors(trans('customer::customers.messages.kyc_required'));
            }
            if (!$customer->is_agent) {
                $this->customerRepository->update($customer, ['is_agent' => TypeCustomerAgentEnum::IS_AGENT]);
                JobSendBecomeAgentSuccess::dispatch($customer);
                return back()->withSuccess(trans('peertopeer::agents.messages.applied_agent_successfully'));
            } else {
                return back()->withErrors(trans('peertopeer::agents.messages.is_agent'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function getCreatePayment()
    {
        try {
            return view('p2p.p2p-add-payment');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
    public function getCreateAd()
    {
        try {
            // $customerID = 40; //auth()->guard('customer');
            // $marketPairs = $this->marketRepository->all();
            return view('p2p.p2p-create-ads');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function editAds($adsId)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $ads = $this->adsRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $adsId]);
            return view('p2p.p2p-edit-ads', compact('ads'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function orderdetail($orderId)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $order = $this->orderRepository->findOrderAgent($orderId, $customer->id);
            if ($order) {
                return view('p2p.agents.orders.detail', compact('order'));
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
