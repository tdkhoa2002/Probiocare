<?php

namespace Modules\ShoppingCart\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ShoppingCart\Entities\Order;
use Modules\ShoppingCart\Http\Requests\CreateOrderRequest;
use Modules\ShoppingCart\Http\Requests\UpdateOrderRequest;
use Modules\ShoppingCart\Repositories\OrderRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class OrderController extends AdminBaseController
{
    /**
     * @var OrderRepository
     */
    private $order;

    public function __construct(OrderRepository $order)
    {
        parent::__construct();

        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('shoppingcart::admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('shoppingcart::admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderRequest $request
     * @return Response
     */
    public function store(CreateOrderRequest $request)
    {
        $this->order->create($request->all());

        return redirect()->route('admin.shoppingcart.order.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('shoppingcart::orders.title.orders')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order $order
     * @return Response
     */
    public function edit(Order $order)
    {
        return view('shoppingcart::admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Order $order
     * @param  UpdateOrderRequest $request
     * @return Response
     */
    public function update(Order $order, UpdateOrderRequest $request)
    {
        $this->order->update($order, $request->all());

        return redirect()->route('admin.shoppingcart.order.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('shoppingcart::orders.title.orders')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order $order
     * @return Response
     */
    public function destroy(Order $order)
    {
        $this->order->destroy($order);

        return redirect()->route('admin.shoppingcart.order.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('shoppingcart::orders.title.orders')]));
    }
}
