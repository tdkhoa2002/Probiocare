<?php

namespace Modules\Peertopeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Peertopeer\Entities\OrderHistory;
use Modules\Peertopeer\Http\Requests\CreateOrderHistoryRequest;
use Modules\Peertopeer\Http\Requests\UpdateOrderHistoryRequest;
use Modules\Peertopeer\Repositories\OrderHistoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class OrderHistoryController extends AdminBaseController
{
    /**
     * @var OrderHistoryRepository
     */
    private $orderhistory;

    public function __construct(OrderHistoryRepository $orderhistory)
    {
        parent::__construct();

        $this->orderhistory = $orderhistory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$orderhistories = $this->orderhistory->all();

        return view('peertopeer::admin.orderhistories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('peertopeer::admin.orderhistories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderHistoryRequest $request
     * @return Response
     */
    public function store(CreateOrderHistoryRequest $request)
    {
        $this->orderhistory->create($request->all());

        return redirect()->route('admin.peertopeer.orderhistory.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('peertopeer::orderhistories.title.orderhistories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  OrderHistory $orderhistory
     * @return Response
     */
    public function edit(OrderHistory $orderhistory)
    {
        return view('peertopeer::admin.orderhistories.edit', compact('orderhistory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderHistory $orderhistory
     * @param  UpdateOrderHistoryRequest $request
     * @return Response
     */
    public function update(OrderHistory $orderhistory, UpdateOrderHistoryRequest $request)
    {
        $this->orderhistory->update($orderhistory, $request->all());

        return redirect()->route('admin.peertopeer.orderhistory.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('peertopeer::orderhistories.title.orderhistories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OrderHistory $orderhistory
     * @return Response
     */
    public function destroy(OrderHistory $orderhistory)
    {
        $this->orderhistory->destroy($orderhistory);

        return redirect()->route('admin.peertopeer.orderhistory.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('peertopeer::orderhistories.title.orderhistories')]));
    }
}
