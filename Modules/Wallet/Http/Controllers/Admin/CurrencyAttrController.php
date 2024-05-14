<?php

namespace Modules\Wallet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Wallet\Entities\CurrencyAttr;
use Modules\Wallet\Http\Requests\CreateCurrencyAttrRequest;
use Modules\Wallet\Http\Requests\UpdateCurrencyAttrRequest;
use Modules\Wallet\Repositories\CurrencyAttrRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CurrencyAttrController extends AdminBaseController
{
    /**
     * @var CurrencyAttrRepository
     */
    private $currencyattr;

    public function __construct(CurrencyAttrRepository $currencyattr)
    {
        parent::__construct();

        $this->currencyattr = $currencyattr;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$currencyattrs = $this->currencyattr->all();

        return view('wallet::admin.currencyattrs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('wallet::admin.currencyattrs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCurrencyAttrRequest $request
     * @return Response
     */
    public function store(CreateCurrencyAttrRequest $request)
    {
        $this->currencyattr->create($request->all());

        return redirect()->route('admin.wallet.currencyattr.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('wallet::currencyattrs.title.currencyattrs')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CurrencyAttr $currencyattr
     * @return Response
     */
    public function edit(CurrencyAttr $currencyattr)
    {
        return view('wallet::admin.currencyattrs.edit', compact('currencyattr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CurrencyAttr $currencyattr
     * @param  UpdateCurrencyAttrRequest $request
     * @return Response
     */
    public function update(CurrencyAttr $currencyattr, UpdateCurrencyAttrRequest $request)
    {
        $this->currencyattr->update($currencyattr, $request->all());

        return redirect()->route('admin.wallet.currencyattr.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('wallet::currencyattrs.title.currencyattrs')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CurrencyAttr $currencyattr
     * @return Response
     */
    public function destroy(CurrencyAttr $currencyattr)
    {
        $this->currencyattr->destroy($currencyattr);

        return redirect()->route('admin.wallet.currencyattr.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('wallet::currencyattrs.title.currencyattrs')]));
    }
}
