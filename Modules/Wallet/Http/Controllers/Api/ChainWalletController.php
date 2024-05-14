<?php

namespace Modules\Wallet\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Wallet\Entities\ChainWallet;
use Modules\Wallet\Http\Requests\CreateChainWalletRequest;
use Modules\Wallet\Http\Requests\UpdateChainWalletRequest;
use Modules\Wallet\Repositories\ChainWalletRepository;
use Modules\Wallet\Transformers\ChainWallets\FullChainWalletTransformer;
use Modules\Wallet\Transformers\ChainWallets\ChainWalletTransformer;

class ChainWalletController extends Controller
{
    /**
     * @var ChainWalletRepository
     */
    private $chainWalletRepository;

    public function __construct(ChainWalletRepository $chainWalletRepository)
    {
        $this->chainWalletRepository = $chainWalletRepository;
    }

    public function all()
    {
        return FullChainWalletTransformer::collection($this->chainWalletRepository->all());
    }

    public function indexServerSide(Request $request)
    {
        return ChainWalletTransformer::collection($this->chainWalletRepository->serverPaginationFilteringFor($request));
    }

    public function store(CreateChainWalletRequest $request)
    {
        $this->chainWalletRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('wallet::chainWallets.messages.chainwallet created'),
        ]);
    }

    public function find($ChainWalletId)
    {
        $ChainWallet = $this->chainWalletRepository->find($ChainWalletId);
        return new FullChainWalletTransformer($ChainWallet);
    }

    public function update(ChainWallet $ChainWallet, UpdateChainWalletRequest $request)
    {
        $this->chainWalletRepository->update($ChainWallet, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('wallet::chainWallets.messages.chainwallet updated'),
        ]);
    }

    public function destroy(ChainWallet $ChainWallet)
    {
        $this->chainWalletRepository->destroy($ChainWallet);
        return response()->json([
            'errors' => false,
            'message' => trans('wallet::chainWallets.messages.chainwallet deleted'),
        ]);
    }
}
