<?php

namespace Modules\Peertopeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Peertopeer\Entities\Ads;
use Modules\Peertopeer\Http\Requests\CreateAdsRequest;
use Modules\Peertopeer\Http\Requests\UpdateAdsRequest;
use Modules\Peertopeer\Repositories\AdsRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AdsController extends AdminBaseController
{
    /**
     * @var AdsRepository
     */
    private $ads;

    public function __construct(AdsRepository $ads)
    {
        parent::__construct();

        $this->ads = $ads;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$ads = $this->ads->all();

        return view('peertopeer::admin.ads.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('peertopeer::admin.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAdsRequest $request
     * @return Response
     */
    public function store(CreateAdsRequest $request)
    {
        $this->ads->create($request->all());

        return redirect()->route('admin.peertopeer.ads.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('peertopeer::ads.title.ads')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Ads $ads
     * @return Response
     */
    public function edit(Ads $ads)
    {
        return view('peertopeer::admin.ads.edit', compact('ads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Ads $ads
     * @param  UpdateAdsRequest $request
     * @return Response
     */
    public function update(Ads $ads, UpdateAdsRequest $request)
    {
        $this->ads->update($ads, $request->all());

        return redirect()->route('admin.peertopeer.ads.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('peertopeer::ads.title.ads')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Ads $ads
     * @return Response
     */
    public function destroy(Ads $ads)
    {
        $this->ads->destroy($ads);

        return redirect()->route('admin.peertopeer.ads.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('peertopeer::ads.title.ads')]));
    }
}
