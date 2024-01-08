<?php

namespace Modules\Cryperrswap\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cryperrswap\Entities\Currency;
use Modules\Cryperrswap\Http\Requests\CreateCurrencyRequest;
use Modules\Cryperrswap\Http\Requests\UpdateCurrencyRequest;
use Modules\Cryperrswap\Repositories\CurrencyRepository;
use Modules\Cryperrswap\Transformers\Currencies\FullCurrencyTransformer;
use Modules\Cryperrswap\Transformers\Currencies\CurrencyTransformer;

class CurrencyController extends Controller
{
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function all()
    {
        return FullCurrencyTransformer::collection($this->currencyRepository->all());
    }

    public function indexServerSide(Request $request)
    {
        return CurrencyTransformer::collection($this->currencyRepository->serverPaginationFilteringFor($request));
    }

    public function store(CreateCurrencyRequest $request)
    {
        $this->currencyRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('cryperrswap::currencies.messages.currency created'),
        ]);
    }

    public function find($currencyId)
    {
        $currency = $this->currencyRepository->find($currencyId);
        return new FullCurrencyTransformer($currency);
    }

    public function update(Currency $currency, UpdateCurrencyRequest $request)
    {
        $this->currencyRepository->update($currency, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('cryperrswap::currencies.messages.currency updated'),
        ]);
    }

    public function destroy(Currency $currency)
    {
        $this->currencyRepository->destroy($currency);
        return response()->json([
            'errors' => false,
            'message' => trans('cryperrswap::currencies.messages.currency deleted'),
        ]);
    }
}
