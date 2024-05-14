<?php

namespace Modules\Trade\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Trade\Entities\Market;
use Modules\Trade\Http\Requests\CreateMarketRequest;
use Modules\Trade\Http\Requests\UpdateMarketRequest;
use Modules\Trade\Repositories\MarketRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class MarketController extends AdminBaseController
{
    /**
     * @var MarketRepository
     */
    private $market;

    public function __construct(MarketRepository $market)
    {
        parent::__construct();

        $this->market = $market;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('trade::admin.markets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('trade::admin.markets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateMarketRequest $request
     * @return Response
     */
    public function store(CreateMarketRequest $request)
    {
        $this->market->create($request->all());

        return redirect()->route('admin.trade.market.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('trade::markets.title.markets')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Market $market
     * @return Response
     */
    public function edit(Market $market)
    {
        return view('trade::admin.markets.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Market $market
     * @param  UpdateMarketRequest $request
     * @return Response
     */
    public function update(Market $market, UpdateMarketRequest $request)
    {
        $this->market->update($market, $request->all());

        return redirect()->route('admin.trade.market.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('trade::markets.title.markets')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Market $market
     * @return Response
     */
    public function destroy(Market $market)
    {
        $this->market->destroy($market);

        return redirect()->route('admin.trade.market.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('trade::markets.title.markets')]));
    }
}
