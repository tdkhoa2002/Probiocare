<?php

namespace Modules\Customer\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Customer\Repositories\PaymentMethodRepository;

class PaymentMethodController extends BasePublicController
{
    /**
     * @var Application
     */
    private $app;
    private $paymentMethodRepository;


    public function __construct(
        Application $app,
        PaymentMethodRepository $paymentMethodRepository
    ) {
        parent::__construct();
        $this->app = $app;
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    public function index($paymentMethodID)
    {
        try {
            $paymentMethod = $this->paymentMethodRepository->find($paymentMethodID);
            if(!$paymentMethod) {
                return back();
            }
            return view('p2p.p2p-add-payment', compact('paymentMethod','paymentMethodID'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

   
}
