<?php

namespace Modules\Wallet\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Wallet\Http\Requests\CreateWalletRequest;
use Modules\Wallet\Jobs\JobSyncWalletAddress;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Transformers\Wallets\WalletTransformer;
use Modules\Wallet\Repositories\WalletChainRepository;

class WalletController extends Controller
{
    /**
     * @var WalletRepository
     */
    private $walletRepository;
    private $walletChainRepository;

    public function __construct(WalletRepository $walletRepository, WalletChainRepository $walletChainRepository)
    {
        $this->walletRepository = $walletRepository;
        $this->walletChainRepository = $walletChainRepository;
    }

    public function indexServerSide(Request $request)
    {
        return WalletTransformer::collection($this->walletRepository->serverPaginationFilteringFor($request));
    }

    public function store(CreateWalletRequest $request)
    {
        $this->walletRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('wallet::wallets.messages.wallet created'),
        ]);
    }

    public function resyncAddress(Request $request)
    {
        $walletChain = $this->walletChainRepository->find($request->get('walletChainId'));
        if ($walletChain) {
            if ($walletChain->is_sync == false) {
                $blockchain = $walletChain->blockchain;
                JobSyncWalletAddress::dispatch($walletChain->address, $blockchain->code, $blockchain->id);
                return response()->json([
                    'errors' => false,
                    'message' => trans('wallet::walletchains.messages.resync_success'),
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'message' => trans('wallet::walletchains.messages.address_synced'),
                ]);
            }
        } else {
            return response()->json([
                'errors' => true,
                'message' => trans('wallet::walletchains.messages.not_found'),
            ]);
        }
    }
}
