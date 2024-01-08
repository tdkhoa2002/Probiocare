<?php

namespace Modules\Wallet\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Wallet\Entities\CrawlHistory;
use Modules\Wallet\Http\Requests\CreateCrawlHistoryRequest;
use Modules\Wallet\Jobs\JobCrawlFundingWallet;
use Modules\Wallet\Repositories\CrawlHistoryRepository;
use Modules\Wallet\Transformers\CrawlHistories\CrawlHistoryTransformer;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Wallet\Repositories\WalletChainRepository;
use Modules\Wallet\Repositories\BlockchainRepository;
use Modules\Wallet\Repositories\CurrencyAttrRepository;
use Modules\Wallet\Repositories\CrawlDepositRepository;
use Modules\Wallet\Transformers\CrawlDeposits\CrawlDepositTransformer;

class CrawlHistoryController extends Controller
{
    /**
     * @var CrawlHistoryRepository
     */
    private $crawlHistoryRepository;
    private $currencyRepository;
    private $walletChainRepository;
    private $blockchainRepository;
    private $crawlDepositRepository;
    private $currencyAttrRepository;

    public function __construct(
        CrawlHistoryRepository $crawlHistoryRepository,
        CurrencyRepository $currencyRepository,
        WalletChainRepository $walletChainRepository,
        BlockchainRepository $blockchainRepository,
        CurrencyAttrRepository $currencyAttrRepository,
        CrawlDepositRepository $crawlDepositRepository
    ) {
        $this->crawlHistoryRepository = $crawlHistoryRepository;
        $this->currencyRepository = $currencyRepository;
        $this->walletChainRepository = $walletChainRepository;
        $this->blockchainRepository = $blockchainRepository;
        $this->currencyAttrRepository = $currencyAttrRepository;
        $this->crawlDepositRepository = $crawlDepositRepository;
    }

    public function indexServerSide(Request $request)
    {
        return CrawlDepositTransformer::collection($this->crawlDepositRepository->serverPaginationFilteringFor($request));
    }

    public function crawl(CreateCrawlHistoryRequest $request)
    {
        $currency = $this->currencyRepository->find($request->currency_id);
        $blockchain = $this->blockchainRepository->find($request->blockchain_id);
        $currencyAttr = $this->currencyAttrRepository->findByAttributes(['currency_id' => $currency->id, 'blockchain_id' => $blockchain->id]);
        $wallets = $this->walletChainRepository->getWalletCanCrawl($currency->min_crawl, $request->blockchain_id, $currency->id);
        if ($blockchain->wallet_receive == null) {
            return response()->json([
                'errors' => true,
                'message' => trans('wallet::crawlhistories.messages.wallet_receive_not_found'),
            ]);
        }
        $crawlDeposit = $this->crawlDepositRepository->create([
            'blockchain_id' => $blockchain->id,
            'currency_id' => $currency->id,
            'user_id' => auth()->user()->id,
            'total' => 0
        ]);
        foreach ($wallets as $wallet) {
            $ownerPrivateKey = decodeString($wallet->private_key);
            JobCrawlFundingWallet::dispatch($crawlDeposit->id, $currencyAttr->token_address, $wallet->id, $blockchain->wallet_receive, $wallet->address, $ownerPrivateKey, $wallet->onhold, $blockchain->rpc, $currencyAttr->decimal);
            sleep(1);
        }
        return response()->json([
            'errors' => false,
            'message' => trans('wallet::crawlhistories.messages.crawl_proccessing'),
        ]);
    }
}
