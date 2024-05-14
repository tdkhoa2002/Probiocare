<?php

namespace Modules\Trade\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Trade\Entities\Trade;
use Modules\Trade\Http\Requests\CreateTradeRequest;
use Modules\Trade\Http\Requests\UpdateTradeRequest;
use Modules\Trade\Repositories\TradeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TradeController extends AdminBaseController
{
    /**
     * @var TradeRepository
     */
    private $trade;

    public function __construct(TradeRepository $trade)
    {
        parent::__construct();

        $this->trade = $trade;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$trades = $this->trade->all();

        return view('trade::admin.trades.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('trade::admin.trades.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTradeRequest $request
     * @return Response
     */
    public function store(CreateTradeRequest $request)
    {
        $this->trade->create($request->all());

        return redirect()->route('admin.trade.trade.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('trade::trades.title.trades')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Trade $trade
     * @return Response
     */
    public function edit(Trade $trade)
    {
        return view('trade::admin.trades.edit', compact('trade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Trade $trade
     * @param  UpdateTradeRequest $request
     * @return Response
     */
    public function update(Trade $trade, UpdateTradeRequest $request)
    {
        $this->trade->update($trade, $request->all());

        return redirect()->route('admin.trade.trade.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('trade::trades.title.trades')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Trade $trade
     * @return Response
     */
    public function destroy(Trade $trade)
    {
        $this->trade->destroy($trade);

        return redirect()->route('admin.trade.trade.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('trade::trades.title.trades')]));
    }
}
