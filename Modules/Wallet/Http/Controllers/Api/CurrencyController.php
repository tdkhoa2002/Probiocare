<?php

namespace Modules\Wallet\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Wallet\Entities\Currency;
use Modules\Wallet\Http\Requests\CreateCurrencyRequest;
use Modules\Wallet\Http\Requests\UpdateCurrencyRequest;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Wallet\Transformers\Currencies\FullCurrencyTransformer;
use Modules\Wallet\Transformers\Currencies\CurrencyTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Wallet\Transformers\Currencies\SmallCurrencySwapTransformer;

class CurrencyController extends BaseApiController
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
        try{
            // dd(CurrencyTransformer::collection($this->currencyRepository->serverPaginationFilteringFor($request)));
            return CurrencyTransformer::collection($this->currencyRepository->serverPaginationFilteringFor($request));
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return false;
        }
    }

    public function store(CreateCurrencyRequest $request)
    {
        $checkCode = $this->currencyRepository->findByAttributes(['code' => $request->get('code')]);
        if ($checkCode) {
            return response()->json([
                'errors' => true,
                'message' => trans('wallet::currencies.messages.currency_code_exsited'),
            ]);
        }
        $this->currencyRepository->create($request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('wallet::currencies.messages.currency created'),
        ]);
    }

    public function find($CurrencyId)
    {
        $Currency = $this->currencyRepository->find($CurrencyId);
        return new FullCurrencyTransformer($Currency);
    }

    public function update(Currency $Currency, UpdateCurrencyRequest $request)
    {
        $this->currencyRepository->update($Currency, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('wallet::currencies.messages.currency updated'),
        ]);
    }

    public function destroy(Currency $Currency)
    {
        $this->currencyRepository->update($Currency, ['status' => false]);
        return response()->json([
            'errors' => false,
            'message' => trans('wallet::currencies.messages.currency deleted'),
        ]);
    }

    public function getCurrencies()
    {
        try {
            $currencies = $this->currencyRepository->getByAttributes(['type' => "CRYPTO", 'status' => true]);
            return $this->respondWithData(['currencies' => FullCurrencyTransformer::collection($currencies)]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }
    public function getFiatCurrencies()
    {
        try {
            $currencies = $this->currencyRepository->getByAttributes(['type' => "FIAT", 'status' => true]);
            return $this->respondWithData(['currencies' => FullCurrencyTransformer::collection($currencies)]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getCurrencyPrice($symbol)
    {
        try {
            $currency = $this->currencyRepository->findByAttributes(['code' => $symbol, 'status' => true]);
            if (!$currency) {
                return $this->respondWithError(trans("wallet::currencies.messages.currency_not_found"));
            }
            return $currency->usd_rate; //new SmallCurrencyTransformer($currency);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getCurrencySwap()
    {
        try {
            $currencies = $this->currencyRepository->getCurrencySwap();
            return $this->respondWithData(['currencies' => SmallCurrencySwapTransformer::collection($currencies)]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getCurrencySwapEnable($currencyId)
    {
        try {
            $currency = $this->currencyRepository->findByAttributes(['id' => $currencyId, 'status' => true]);
            if ($currency) {
                if ($currency->swap_enable != null) {
                    $swap_enable = json_decode($currency->swap_enable);
                    $currencies = $this->currencyRepository->getCurrencySwapEnable($swap_enable);
                    return $this->respondWithData(['currencies' => SmallCurrencySwapTransformer::collection($currencies)]);
                } else {
                    return $this->respondWithData(['currencies' => []]);
                }
            } else {
                return $this->respondWithError(trans("wallet::currencies.messages.currency_not_found"));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function detailCurrency($currencyId)
    {
        try {
            $currency = $this->currencyRepository->findByAttributes(['id' => $currencyId, 'status' => true]);
            if ($currency) {
                return $this->respondWithData(['currency' => new SmallCurrencySwapTransformer($currency)]);
            } else {
                return $this->respondWithError(trans("wallet::currencies.messages.currency_not_found"));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }
}
