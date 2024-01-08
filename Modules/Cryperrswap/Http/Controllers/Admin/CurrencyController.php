<?php

namespace Modules\Cryperrswap\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cryperrswap\Entities\Currency;
use Modules\Cryperrswap\Http\Requests\CreateCurrencyRequest;
use Modules\Cryperrswap\Http\Requests\UpdateCurrencyRequest;
use Modules\Cryperrswap\Repositories\CurrencyRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CurrencyController extends AdminBaseController
{
    /**
     * @var CurrencyRepository
     */
    private $currency;

    public function __construct(CurrencyRepository $currency)
    {
        parent::__construct();

        $this->currency = $currency;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('cryperrswap::admin.currencies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('cryperrswap::admin.currencies.create');
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Currency $currency
     * @return Response
     */
    public function edit(Currency $currency)
    {
        return view('cryperrswap::admin.currencies.edit', compact('currency'));
    }
}
