<?php

namespace Modules\Loyalty\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Loyalty\Entities\Order;
use Modules\Loyalty\Http\Requests\CreateOrderRequest;
use Modules\Loyalty\Http\Requests\UpdateOrderRequest;
use Modules\Loyalty\Repositories\OrderRepository;
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
        return view('staking::admin.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function detail()
    {
        return view('staking::admin.orders.detail');
    }
}
