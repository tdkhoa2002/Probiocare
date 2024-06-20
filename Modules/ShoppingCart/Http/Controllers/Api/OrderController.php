<?php

namespace Modules\ShoppingCart\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ShoppingCart\Entities\Order;
use Modules\ShoppingCart\Enums\StatusOrderEnum;
use Modules\ShoppingCart\Http\Requests\UpdateOrderRequest;
use Modules\ShoppingCart\Repositories\OrderRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\ShoppingCart\Transformers\FullOrderTransformer;
use Modules\ShoppingCart\Transformers\OrderTransformer;
use Modules\Customer\Jobs\JobSendEmailOrderCancel;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Events\UpdateBalanceWallet;

class OrderController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    private $customerRepository;
    private $currencyRepository;
    private $walletRepository;
    private $transactionRepository;

    public function __construct(
        OrderRepository $orderRepository, 
        CustomerRepository $customerRepository,
        CurrencyRepository $currencyRepository,
        WalletRepository $walletRepository,
        TransactionRepository $transactionRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->currencyRepository = $currencyRepository;
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function indexServerSide(Request $request)
    {
        return OrderTransformer::collection($this->orderRepository->serverPaginationFilteringFor($request));
    }

    public function find(Request $request)
    {
        $orderId = $request->orderId;
        $Order = $this->orderRepository->find($orderId);
        return new FullOrderTransformer($Order);
    }

    public function update($OrderId, UpdateOrderRequest $request)
    {
        $Order = $this->orderRepository->find($OrderId);
        $this->orderRepository->update($Order, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('shoppingcart::messages.order updated'),
        ]);
    }

    public function destroy($orderId, Order $Order)
    {
        $order = $this->orderRepository->find($orderId);
        $adminId = auth()->user()->id;
        if($order->status !== "CANCELED") {
            $customer = $this->customerRepository->findByAttributes(['email' => $order->email]);
            //Send email
            // JobSendEmailOrderCancel::dispatch($customer, $orderId);
            // $this->orderRepository->destroy($order);
            $rq = [ 
                'status' => StatusOrderEnum::CANCELED
            ];
            $orderUpdated = $this->orderRepository->update($order, $rq);
            //Update Balance For User
            $action = "VOUCHER_REFUND";
            $currency = $this->currencyRepository->findByAttributes([
                'id' => 2
            ]);
            $wallet = $this->walletRepository->findByAttributes([
                'customer_id' => $customer->id,
                'currency_id' => 2
            ]);
            if(!$wallet) {
                $dataCreate = [
                    'customer_id' =>  $customer->id,
                    'currency_id' => 2,
                    'type' => 'CRYPTO',
                    'balance' => 0,
                    'status' => true,
                ];
                $wallet = $this->walletRepository->create($dataCreate);
            }
            $newBalance = $wallet->balance + 20;
            $dataCreate = [
                'customer_id' => $customer->id,
                'currency_id' => 2,
                'blockchain_id' => null,
                'action' => TypeTransactionActionEnum::VOUCHER_REFUND,
                'amount' => 20,
                'amount_usd' => 20 * $currency->usd_rate,
                'fee' => 0,
                'balance' => $newBalance,
                'balanceBefore' => $wallet->balance,
                'payment_method' => 'CRYPTO',
                'txhash' => random_strings(30),
                'from' => "",
                'to' => "",
                'tag' => null,
                'order' => 0,
                'note' => "",
                'status' => StatusTransactionEnum::COMPLETED,
                'created_by' => $adminId
            ];
            $this->transactionRepository->create($dataCreate);
            event(new UpdateBalanceWallet($newBalance, $wallet->id));
            //
        }
        return response()->json([
            'errors' => false,
            'message' => trans('shoppingcart::orders.messages.order_cancelled'),
        ]);
    }

    public function getStatusOrder(){
        return response()->json([
            'errors' => false,
            'statusOrder' => StatusOrderEnum::cases(),
        ]);
    }
}
