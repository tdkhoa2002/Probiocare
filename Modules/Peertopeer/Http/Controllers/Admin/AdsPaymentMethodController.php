<?php

namespace Modules\Peertopeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Peertopeer\Entities\AdsPaymentMethod;
use Modules\Peertopeer\Http\Requests\CreateAdsPaymentMethodRequest;
use Modules\Peertopeer\Http\Requests\UpdateAdsPaymentMethodRequest;
use Modules\Peertopeer\Repositories\AdsPaymentMethodRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AdsPaymentMethodController extends AdminBaseController
{
    /**
     * @var AdsPaymentMethodRepository
     */
    private $adspaymentmethod;

    public function __construct(AdsPaymentMethodRepository $adspaymentmethod)
    {
        parent::__construct();

        $this->adspaymentmethod = $adspaymentmethod;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$adspaymentmethods = $this->adspaymentmethod->all();

        return view('peertopeer::admin.adspaymentmethods.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('peertopeer::admin.adspaymentmethods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAdsPaymentMethodRequest $request
     * @return Response
     */
    public function store(CreateAdsPaymentMethodRequest $request)
    {
        $this->adspaymentmethod->create($request->all());

        return redirect()->route('admin.peertopeer.adspaymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('peertopeer::adspaymentmethods.title.adspaymentmethods')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AdsPaymentMethod $adspaymentmethod
     * @return Response
     */
    public function edit(AdsPaymentMethod $adspaymentmethod)
    {
        return view('peertopeer::admin.adspaymentmethods.edit', compact('adspaymentmethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AdsPaymentMethod $adspaymentmethod
     * @param  UpdateAdsPaymentMethodRequest $request
     * @return Response
     */
    public function update(AdsPaymentMethod $adspaymentmethod, UpdateAdsPaymentMethodRequest $request)
    {
        $this->adspaymentmethod->update($adspaymentmethod, $request->all());

        return redirect()->route('admin.peertopeer.adspaymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('peertopeer::adspaymentmethods.title.adspaymentmethods')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AdsPaymentMethod $adspaymentmethod
     * @return Response
     */
    public function destroy(AdsPaymentMethod $adspaymentmethod)
    {
        $this->adspaymentmethod->destroy($adspaymentmethod);

        return redirect()->route('admin.peertopeer.adspaymentmethod.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('peertopeer::adspaymentmethods.title.adspaymentmethods')]));
    }
}
