<?php

namespace Modules\Trade\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Trade\Entities\Market;
use Modules\Trade\Http\Requests\CreateMarketRequest;
use Modules\Trade\Http\Requests\UpdateMarketRequest;
use Modules\Trade\Libraries\Tatum;
use Modules\Trade\Repositories\MarketRepository;
use Modules\Trade\Transformers\Markets\FullMarketTransformer;
use Modules\Trade\Transformers\Markets\MarketTransformer;

class MarketController extends Controller
{
    /**
     * @var MarketRepository
     */
    private $marketRepository;

    public function __construct(MarketRepository $marketRepository)
    {
        $this->marketRepository = $marketRepository;
    }

    public function all()
    {
        return FullMarketTransformer::collection($this->marketRepository->all());
    }

    public function indexServerSide(Request $request)
    {
        return MarketTransformer::collection($this->marketRepository->serverPaginationFilteringFor($request));
    }

    public function store(CreateMarketRequest $request)
    {
        $tatumApiKey = setting('trade::tatum_api_key');
        if (!$tatumApiKey) {
            return response()->json([
                'errors' => true,
                'message' => trans('trade::markets.messages.tatum_api_key_required'),
            ]);
        }

        $customerId = setting('trade::tatum_customer_key');
        if (!$customerId) {
            return response()->json([
                'errors' => true,
                'message' => trans('trade::markets.messages.tatum_customer_key_required'),
            ]);
        }

        $market =  $this->marketRepository->create($request->all());
        $tatum = new Tatum($tatumApiKey);
        $currency = $market->currency;
        $currencyPair = $market->currencyPair;
        $data = $tatum->createVirtualCurrency(strtoupper($currency->code) . "_" . $market->id, $customerId);
        if ($data) {
            $dataUpdate = [
                'service_base_code' => $data['currency'], 'service_base_id' => $data['id'], 'service_customer_id' => $data['customer_id']
            ];
            $this->marketRepository->update($market, $dataUpdate);
        }
        $dataPair = $tatum->createVirtualCurrency(strtoupper($currencyPair->code) . "_" . $market->id, $customerId);
        if ($dataPair) {
            $dataUpdate = [
                'service_quote_code' => $dataPair['currency'], 'service_quote_id' => $dataPair['id'], 'service_customer_id' => $dataPair['customer_id']
            ];
            $this->marketRepository->update($market, $dataUpdate);
        }
        return response()->json([
            'errors' => false,
            'message' => trans('trade::markets.messages.market created'),
        ]);
    }

    public function reSyncService($marketId)
    {
        $tatumApiKey = setting('trade::tatum_api_key');
        if (!$tatumApiKey) {
            return response()->json([
                'errors' => true,
                'message' => trans('trade::markets.messages.tatum_api_key_required'),
            ]);
        }

        $customerId = setting('trade::tatum_customer_key');
        if (!$customerId) {
            return response()->json([
                'errors' => true,
                'message' => trans('trade::markets.messages.tatum_customer_key_required'),
            ]);
        }

        $market = $this->marketRepository->find($marketId);
        $currency = $market->currency;
        $currencyPair = $market->currencyPair;
        $tatum = new Tatum($tatumApiKey);
        if ($market->service_base_code == null) {
            $data = $tatum->createVirtualCurrency(strtoupper($currency->code) . "_" . $market->id, $customerId);
            if ($data) {
                $dataUpdate = [
                    'service_base_code' => $data['currency'], 'service_base_id' => $data['id'], 'service_customer_id' => $data['customer_id']
                ];
                $this->marketRepository->update($market, $dataUpdate);
            }
        }

        if ($market->service_quote_code == null) {
            $dataPair = $tatum->createVirtualCurrency(strtoupper($currencyPair->code) . "_" . $market->id, $customerId);
            if ($dataPair) {
                $dataUpdate = [
                    'service_quote_code' => $dataPair['currency'], 'service_quote_id' => $dataPair['id'], 'service_customer_id' => $dataPair['customer_id']
                ];
                $this->marketRepository->update($market, $dataUpdate);
            }
        }

        return response()->json([
            'errors' => false,
            'message' => trans('trade::markets.messages.market sync_success'),
        ]);
    }


    public function find($MarketId)
    {
        $Market = $this->marketRepository->find($MarketId);
        return new FullMarketTransformer($Market);
    }

    public function update(Market $Market, UpdateMarketRequest $request)
    {
        $this->marketRepository->update($Market, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('trade::markets.messages.market updated'),
        ]);
    }

    public function destroy(Market $Market)
    {
        $this->marketRepository->destroy($Market);
        return response()->json([
            'errors' => false,
            'message' => trans('trade::markets.messages.Market deleted'),
        ]);
    }
}
