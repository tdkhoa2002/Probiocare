<?php

namespace Modules\ShoppingCart\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ShoppingCart\Entities\Order;
use Modules\ShoppingCart\Http\Requests\UpdateOrderRequest;
use Modules\ShoppingCart\Repositories\OrderRepository;
use Modules\ShoppingCart\Transformers\FullOrderTransformer;
use Modules\ShoppingCart\Transformers\OrderTransformer;

class OrderController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
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

    public function destroy(Order $Order)
    {
        $this->orderRepository->destroy($Order);
        return response()->json([
            'errors' => false,
            'message' => trans('shoppingcart::messages.order deleted'),
        ]);
    }
}
