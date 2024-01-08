<?php

namespace Modules\Staking\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Staking\Entities\Order;
use Modules\Staking\Repositories\OrderRepository;
use Modules\Staking\Transformers\Orders\AdminOrderTransformer;
use Modules\Staking\Transformers\Orders\FullAdminOrderTransformer;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Wallet\Transformers\Transactions\FullTransactionTransformer;
use Modules\Wallet\Transformers\Transactions\ListWithdrawTransformer;
use Modules\Wallet\Transformers\Transactions\TransactionTransformer;

class OrderAdminController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    private $transactionRepository;

    public function __construct(OrderRepository $orderRepository, TransactionRepository $transactionRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function indexServerSide(Request $request)
    {
        return AdminOrderTransformer::collection($this->orderRepository->serverPaginationFilteringFor($request));
    }

    public function detail(Order $order)
    {
        return new FullAdminOrderTransformer($order);
    }

    public function getTransaction($orderId)
    {
        $transactions = $this->transactionRepository->getTransactionStaking($orderId);
        return TransactionTransformer::collection($transactions);
    }
}
