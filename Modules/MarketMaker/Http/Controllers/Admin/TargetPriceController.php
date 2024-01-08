<?php

namespace Modules\MarketMaker\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\MarketMaker\Entities\TargetPrice;
use Modules\MarketMaker\Http\Requests\CreateTargetPriceRequest;
use Modules\MarketMaker\Http\Requests\UpdateTargetPriceRequest;
use Modules\MarketMaker\Repositories\TargetPriceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TargetPriceController extends AdminBaseController
{
    /**
     * @var TargetPriceRepository
     */
    private $targetprice;

    public function __construct(TargetPriceRepository $targetprice)
    {
        parent::__construct();

        $this->targetprice = $targetprice;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$targetprices = $this->targetprice->all();

        return view('marketmaker::admin.targetprices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('marketmaker::admin.targetprices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTargetPriceRequest $request
     * @return Response
     */
    public function store(CreateTargetPriceRequest $request)
    {
        $this->targetprice->create($request->all());

        return redirect()->route('admin.marketmaker.targetprice.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('marketmaker::targetprices.title.targetprices')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TargetPrice $targetprice
     * @return Response
     */
    public function edit(TargetPrice $targetprice)
    {
        return view('marketmaker::admin.targetprices.edit', compact('targetprice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TargetPrice $targetprice
     * @param  UpdateTargetPriceRequest $request
     * @return Response
     */
    public function update(TargetPrice $targetprice, UpdateTargetPriceRequest $request)
    {
        $this->targetprice->update($targetprice, $request->all());

        return redirect()->route('admin.marketmaker.targetprice.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('marketmaker::targetprices.title.targetprices')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TargetPrice $targetprice
     * @return Response
     */
    public function destroy(TargetPrice $targetprice)
    {
        $this->targetprice->destroy($targetprice);

        return redirect()->route('admin.marketmaker.targetprice.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('marketmaker::targetprices.title.targetprices')]));
    }
}
