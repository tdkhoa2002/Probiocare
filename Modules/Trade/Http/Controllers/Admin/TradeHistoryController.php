<?php

namespace Modules\Trade\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Trade\Entities\TradeHistory;
use Modules\Trade\Http\Requests\CreateTradeHistoryRequest;
use Modules\Trade\Http\Requests\UpdateTradeHistoryRequest;
use Modules\Trade\Repositories\TradeHistoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TradeHistoryController extends AdminBaseController
{
    /**
     * @var TradeHistoryRepository
     */
    private $tradehistory;

    public function __construct(TradeHistoryRepository $tradehistory)
    {
        parent::__construct();

        $this->tradehistory = $tradehistory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$tradehistories = $this->tradehistory->all();

        return view('trade::admin.tradehistories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('trade::admin.tradehistories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTradeHistoryRequest $request
     * @return Response
     */
    public function store(CreateTradeHistoryRequest $request)
    {
        $this->tradehistory->create($request->all());

        return redirect()->route('admin.trade.tradehistory.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('trade::tradehistories.title.tradehistories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TradeHistory $tradehistory
     * @return Response
     */
    public function edit(TradeHistory $tradehistory)
    {
        return view('trade::admin.tradehistories.edit', compact('tradehistory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TradeHistory $tradehistory
     * @param  UpdateTradeHistoryRequest $request
     * @return Response
     */
    public function update(TradeHistory $tradehistory, UpdateTradeHistoryRequest $request)
    {
        $this->tradehistory->update($tradehistory, $request->all());

        return redirect()->route('admin.trade.tradehistory.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('trade::tradehistories.title.tradehistories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TradeHistory $tradehistory
     * @return Response
     */
    public function destroy(TradeHistory $tradehistory)
    {
        $this->tradehistory->destroy($tradehistory);

        return redirect()->route('admin.trade.tradehistory.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('trade::tradehistories.title.tradehistories')]));
    }
}
