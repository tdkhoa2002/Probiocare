<?php

namespace Modules\Trade\Libraries;

use Tatum\Sdk;
use Tatum\Model\CreateAccount;
use Tatum\Model\CustomerRegistration;

class Tatum
{
    protected $tatum;
    protected $net;
    protected $api;
    public function __construct($apiKey)
    {
        $this->tatum = new Sdk();
        $this->tatum->mainnet()->config()->setApiKey($apiKey);
        $this->api = $this->tatum->mainnet()->api();
    }

    public function createAccount($setCurrency, $customerId)
    {
        try {
            $customer = (new CustomerRegistration())->setExternalId($customerId);
            $arg_create_account = (new CreateAccount())
                ->setCurrency($setCurrency)
                ->setCustomer($customer)
                ->setCompliant(false)
                ->setAccountCode('AC_' . $customerId)
                ->setAccountingCurrency('USD')
                ->setAccountNumber($customerId);
            return $this->api->account()->createAccount($arg_create_account);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function createVirtualCurrency($currencyCode, $customerId)
    {
        try {
            $customer = (new CustomerRegistration())->setExternalId($customerId);
            $arg_virtual_currency = (new \Tatum\Model\VirtualCurrency())
                ->setName('VC_' . $currencyCode)
                ->setSupply('999999999999999999999999999999')
                ->setCustomer($customer)
                ->setBasePair('USDT')
                ->setBaseRate(1)
                ->setAccountingCurrency('USD');
            return $this->api->virtualCurrency()->createCurrency($arg_virtual_currency);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function createTrade($type, $price, $amount, $pair, $currency1, $currency2)
    {
        try {
            $arg_create_trade = (new \Tatum\Model\CreateTrade())
                ->setType($type)
                ->setPrice($price)
                ->setAmount($amount)
                ->setPair($pair)
                ->setCurrency1AccountId($currency1)
                ->setCurrency2AccountId($currency2);
            $order = $this->api->orderBook()->createTrade($arg_create_trade);
            if ($order) {
                return ['error' => false, 'order' => $order];
            } else {
                return ['error' => true, 'message' => "error"];
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function chartRequest($currency1, $currency2, $from, $to, $timeframe="MIN_5")
    {
        try {
            $from = ($from > 0) ? $from : 0;
            $arg_chart_request = (new \Tatum\Model\ChartRequest())
                ->setPair('VC_'.$currency1.'/VC_'.$currency2)
                ->setFrom($from)
                ->setTo($to)
                ->setTimeFrame($timeframe);
            return $this->api->orderBook()->chartRequest($arg_chart_request);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function getHistoryTrade()
    {
        try {
            $arg_list_oder_book_history_body = (new \Tatum\Model\ListOderBookHistoryBody())->setPageSize(10);
            return $this->api->orderBook()->getHistoricalTradesBody($arg_list_oder_book_history_body);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function getBuyTradesBody()
    {
        try {
            $arg_list_oder_book_history_body = (new \Tatum\Model\ListOderBookActiveBuyBody())->setPageSize(10);
            return $this->api->orderBook()->getBuyTradesBody($arg_list_oder_book_history_body);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function getSellTradesBody()
    {
        try {
            $arg_list_oder_book_history_body = (new \Tatum\Model\ListOderBookActiveSellBody())->setPageSize(10);
            return $this->api->orderBook()->getSellTradesBody($arg_list_oder_book_history_body);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function sendTransaction()
    {
        try {
            $arg_list_oder_book_history_body = (new \Tatum\Model\CreateTransaction())
                ->setSenderAccountId('648c8b3d20a3cd5e50414ccb')
                ->setRecipientAccountId('648c8cd0946f216fc6c87a1c')
                ->setAmount('50');
            return $this->api->transaction()->sendTransaction($arg_list_oder_book_history_body);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function createSubscriptionPartialTradeMatch($customerId, $url)
    {
        try {
            $arg_create_subscription_partial_trade_match = (new \Tatum\Model\CreateSubscriptionPartialTradeMatch())
                ->setType("CUSTOMER_PARTIAL_TRADE_MATCH")
                ->setAttr((new \Tatum\Model\CreateSubscriptionPartialTradeMatchAttr())->setId($customerId)->setUrl($url));
            return $this->api->notificationSubscriptions()->createSubscriptionPartialTradeMatch($arg_create_subscription_partial_trade_match);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function createSubscriptionTradeMatch($customerId, $url)
    {
        try {
            $arg_create_subscription_trade_match  = (new \Tatum\Model\CreateSubscriptionTradeMatch())
                ->setType("CUSTOMER_TRADE_MATCH")
                ->setAttr((new \Tatum\Model\CreateSubscriptionTradeMatchAttr())->setId($customerId)->setUrl($url));
            return $this->api->notificationSubscriptions()->createSubscriptionTradeMatch($arg_create_subscription_trade_match);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function deleteTrade($arg_id)
    {
        try {
            return $this->api
                ->orderBook()
                ->deleteTrade($arg_id);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }
}
