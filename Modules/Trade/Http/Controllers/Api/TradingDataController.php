<?php

namespace Modules\Trade\Http\Controllers\Api;

use Illuminate\Contracts\Foundation\Application;
use Modules\Trade\Repositories\MarketRepository;
use Modules\Trade\Repositories\TradeHistoryRepository;
use Modules\Trade\Repositories\TradeRepository;
use Modules\Trade\Transformers\Market\FullPairInfoTransformer;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use Modules\Trade\Transformers\TradeHistories\TradeHistoriesTransformer;

class TradingDataController extends BaseApiController
{
    /**
     * @var Application
     */
    private $app;
    private $marketRepository;
    private $tradeHistoryRepository;
    private $tradeRepository;

    public function __construct(
        Application $app,
        MarketRepository $marketRepository,
        TradeHistoryRepository $tradeHistoryRepository,
        TradeRepository $tradeRepository
    ) {
        parent::__construct();
        $this->app = $app;
        $this->marketRepository = $marketRepository;
        $this->tradeHistoryRepository = $tradeHistoryRepository;
        $this->tradeRepository = $tradeRepository;
    }

    public function getOrderData($symbol, $type)
    {

        $data = [];
        if ($type == 'ask') {
            for ($i = 0; $i < 12; $i++) {
                $data[$i] = [
                    'price' => 24 - $i,
                    'amount' => rand(10, 100),
                ];
            };
        } else {
            for ($i = 0; $i < 12; $i++) {
                $data[$i] = [
                    'price' => 12 - $i,
                    'amount' => rand(10, 100),
                ];
            };
        }

        $responseData = [
            "symbol" => $symbol,
            "type" => $type,
            "data" => $data
        ];
        return $this->respondWithData($responseData);
    }

    public function getMarketTrades($symbol, Request $request)
    {
        $marketPair = $this->marketRepository->where('symbol', $symbol)->first();

        if ($request->get('to')) {
            $tradeHistories = $this->tradeHistoryRepository->getTradeHistoriesWithLimit($marketPair->id, 1000, $request->get('to'));
        } else {
            $tradeHistories = $marketPair->tradeHistories;
        }
        $transformData = new FullPairInfoTransformer($marketPair);
        return $this->respondWithData(["pair" => $transformData, "tradeHistories" => $tradeHistories]);
    }

    public function getMyTrades($customerID, $symbol)
    {
        $marketPair = $this->marketRepository->where('symbol', $symbol)->first();
        $trades = $this->tradeRepository->where('customer_id', $customerID)
            ->where('market_id', $marketPair->id)
            ->orderBy('id', 'desc')
            ->get();
        return $this->respondWithData($trades);
    }

    public function getPairInfo($symbol)
    {
        try {
            $marketPair = $this->marketRepository->findByAttributes(['symbol' => $symbol]);
            if (!$marketPair) {
                return $this->respondWithError(trans('trade::markets.messages.pair_not_found'));
            }

            $tradeHistories = $this->tradeHistoryRepository->getTradeHistoriesNewest($marketPair->id);
            $tradeHistories = TradeHistoriesTransformer::collection($tradeHistories);
            $transformData = new FullPairInfoTransformer($marketPair);
            return $this->respondWithData(['pairInfo' => $transformData, 'tradeHistories' => $tradeHistories]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getMarkets()
    {
        $marketPair = $this->marketRepository->getByAttributes(['status' => true],'price_change_24h','desc');
        $transformData = FullPairInfoTransformer::collection($marketPair);
        return $this->respondWithData($transformData);
    }

    public function chartRequest(Request $request)
    {
        // $symbol, $from, $to , $timeframe="MIN_5"
        $marketPair = $this->marketRepository->findByAttributes(['symbol' => $request->symbol]);
        dd($marketPair);
        $to = $request->to * 1000;
        $res = $request->res;
        switch ($request->res) {
            case 'MIN_15':
                $diffInMin = 15;
                break;
            case 'MIN_30':
                $diffInMin = 30;
                break;
            case 'HOUR_1':
                $diffInMin = 60;
                break;
            case 'HOUR_4':
                $diffInMin = 60 * 4;
                break;
            case 'HOUR_12':
                $diffInMin = 60 * 12;
                break;
            case 'DAY':
                $diffInMin = 60 * 24;
                break;
            case 'WEEK':
                $diffInMin = 60 * 24 * 7;
                break;
            case 'MONTH':
                $diffInMin = 60 * 24 * 30;
                break;
            case 'YEAR':
                $diffInMin = 60 * 24 * 365;
                break;

            default:
                $diffInMin = 5;
                $res = "MIN_5";
                break;
        }
        $from = $to - 199 * $diffInMin * 60 * 1000;
        // dd($from , $to, $to - $from);
        //$tatum = new Tatum();
        //   $candle = $tatum->chartRequest($marketPair->currency->code, $marketPair->currencyPair->code,  $from, $to, $res);
        // dd($candle);
        return $this->respondWithData($candle);
    }
}
