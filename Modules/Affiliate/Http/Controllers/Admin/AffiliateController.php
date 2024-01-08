<?php

namespace Modules\Affiliate\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Affiliate\Entities\Affiliate;
use Modules\Affiliate\Http\Requests\CreateAffiliateRequest;
use Modules\Affiliate\Http\Requests\UpdateAffiliateRequest;
use Modules\Affiliate\Repositories\AffiliateRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AffiliateController extends AdminBaseController
{
    /**
     * @var AffiliateRepository
     */
    private $affiliate;

    public function __construct(AffiliateRepository $affiliate)
    {
        parent::__construct();

        $this->affiliate = $affiliate;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$affiliates = $this->affiliate->all();

        return view('affiliate::admin.affiliates.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('affiliate::admin.affiliates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAffiliateRequest $request
     * @return Response
     */
    public function store(CreateAffiliateRequest $request)
    {
        $this->affiliate->create($request->all());

        return redirect()->route('admin.affiliate.affiliate.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('affiliate::affiliates.title.affiliates')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Affiliate $affiliate
     * @return Response
     */
    public function edit(Affiliate $affiliate)
    {
        return view('affiliate::admin.affiliates.edit', compact('affiliate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Affiliate $affiliate
     * @param  UpdateAffiliateRequest $request
     * @return Response
     */
    public function update(Affiliate $affiliate, UpdateAffiliateRequest $request)
    {
        $this->affiliate->update($affiliate, $request->all());

        return redirect()->route('admin.affiliate.affiliate.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('affiliate::affiliates.title.affiliates')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Affiliate $affiliate
     * @return Response
     */
    public function destroy(Affiliate $affiliate)
    {
        $this->affiliate->destroy($affiliate);

        return redirect()->route('admin.affiliate.affiliate.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('affiliate::affiliates.title.affiliates')]));
    }
}
