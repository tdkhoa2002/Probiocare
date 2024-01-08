<?php

namespace Modules\Peertopeer\Http\Controllers;

use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Customer\Repositories\PaymentMethodRepository;
use Modules\Peertopeer\Repositories\AdsRepository;
use Modules\Customer\Repositories\PaymentMethodCustomerRepository;
use Illuminate\Http\Request;
use Modules\Peertopeer\Repositories\OrderRepository;

class PublicController extends BasePublicController
{
    private $currencyRepository;
    private $paymentMethodRepository;
    private $adsRepository;
    private $paymentMethodCustomerRepository;
    private $orderRepository;
    public function __construct(
        CurrencyRepository $currencyRepository,
        PaymentMethodRepository $paymentMethodRepository,
        AdsRepository $adsRepository,
        PaymentMethodCustomerRepository $paymentMethodCustomerRepository,
        OrderRepository $orderRepository
    ) {
        parent::__construct();
        $this->currencyRepository = $currencyRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->adsRepository = $adsRepository;
        $this->paymentMethodCustomerRepository = $paymentMethodCustomerRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index(Request $request)
    {
        try {
            if (!auth()->guard('customer')->check()) {
                return redirect()->route('fe.customer.customer.login');
            }
            $customer = auth()->guard('customer')->user();
            $currencies = $this->currencyRepository->all();
            $paymentMethods = $this->paymentMethodRepository->all();
            $myPaymentMethods = $this->paymentMethodCustomerRepository->getByAttributes(['customer_id' => $customer->id]);
            $ads = $this->adsRepository->where('customer_id',  $customer->id)
                ->orderBy('fixed_price', 'desc')
                ->get();
            return view('p2p.p2p', compact('currencies', 'paymentMethods', 'ads', 'customer', 'myPaymentMethods'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
    public function center(Request $request)
    {
        try {
            if (!auth()->guard('customer')->check()) {
                return redirect()->route('fe.customer.customer.login');
            }
            $customer = auth()->guard('customer')->user();
            $currencies = $this->currencyRepository->all();
            $paymentMethods = $this->paymentMethodRepository->all();
            $myPaymentMethods = $this->paymentMethodCustomerRepository->getByAttributes(['customer_id' => $customer->id]);
            $ads = $this->adsRepository->where('customer_id',  $customer->id)
                ->orderBy('fixed_price', 'desc')
                ->get();
            return view('p2p.p2p-center', compact('currencies', 'paymentMethods', 'ads', 'customer', 'myPaymentMethods'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

   

    public function orders(Request $request)
    {
        try {
            if (!auth()->guard('customer')->check()) {
                return redirect()->route('fe.customer.customer.login');
            }
            $customer = auth()->guard('customer')->user();
            $currencies = $this->currencyRepository->all();
            $paymentMethods = $this->paymentMethodRepository->all();
            $myPaymentMethods = $this->paymentMethodCustomerRepository->getByAttributes(['customer_id' => $customer->id]);
            $ads = $this->adsRepository->where('customer_id',  $customer->id)
                ->orderBy('fixed_price', 'desc')
                ->get();
            return view('p2p.p2p-orders', compact('currencies', 'paymentMethods', 'ads', 'customer', 'myPaymentMethods'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function orderDetail($orderId, Request $request)
    {
        try {
            if (!auth()->guard('customer')->check()) {
                return redirect()->route('fe.customer.customer.login');
            }
            $customer = auth()->guard('customer')->user();
            $order = $this->orderRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $orderId]);
            if ($order) {
                return view('p2p.p2p-order', compact('order'));
            } else {
                abort(404);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function getCreateOrder($adID)
    {
        try {
            $ads = $this->adsRepository->find($adID);
            return view('p2p.p2p-create-order', compact('ads'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
