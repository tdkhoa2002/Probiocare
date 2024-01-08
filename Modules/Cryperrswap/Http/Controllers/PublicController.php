<?php

namespace Modules\Cryperrswap\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Cryperrswap\Http\Requests\CalExchangeRequest;
use Modules\Cryperrswap\Http\Requests\ExchangeRequest;
use Modules\Cryperrswap\Repositories\OrderRepository;
use Modules\Cryperrswap\Repositories\ServiceRepository;
use Modules\Cryperrswap\Services\FixedFloatApi;
use Modules\Cryperrswap\Repositories\CurrencyRepository;
use Illuminate\Http\Request;

class PublicController extends BasePublicController
{
    /**
     * @var Application
     */
    private $app;
    private $orderRepository;
    private $serviceRepository;
    private $currencyRepository;

    public function __construct(
        Application $app,
        OrderRepository $orderRepository,
        ServiceRepository $serviceRepository,
        CurrencyRepository $currencyRepository
    ) {
        parent::__construct();
        $this->app = $app;
        $this->orderRepository = $orderRepository;
        $this->serviceRepository = $serviceRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function getTxn($orderCode)
    {
        $order = $this->orderRepository->findByAttributes(['order_code' => $orderCode]);
        if ($order) {
            return view('page.txn', compact('order'));
        } else {
            return view('page.txn');
        }
    }
    public function getFindOrder(Request $request)
    {
        if(isset($request->code)){
            $order = $this->orderRepository->findByAttributes(['order_code' => $request->code]);
            if(!$order){
                return view('page.find-txn');
            }
            return view('page.txn', compact('order'));
        }
        return view('page.find-txn');
    }
}