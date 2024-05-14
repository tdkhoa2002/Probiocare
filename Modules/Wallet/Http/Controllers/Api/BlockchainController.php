<?php

namespace Modules\Wallet\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Wallet\Entities\Blockchain;
use Modules\Wallet\Http\Requests\CreateBlockchainRequest;
use Modules\Wallet\Http\Requests\UpdateBlockchainRequest;
use Modules\Wallet\Repositories\BlockchainRepository;
use Modules\Wallet\Transformers\Blockchains\FullBlockchainTransformer;
use Modules\Wallet\Transformers\Blockchains\BlockchainTransformer;

class BlockchainController extends Controller
{
    /**
     * @var BlockchainRepository
     */
    private $blockchainRepository;

    public function __construct(BlockchainRepository $blockchainRepository)
    {
        $this->blockchainRepository = $blockchainRepository;
    }

    public function all()
    {
        return FullBlockchainTransformer::collection($this->blockchainRepository->all());
    }

    public function indexServerSide(Request $request)
    {
        return BlockchainTransformer::collection($this->blockchainRepository->serverPaginationFilteringFor($request));
    }

    public function store(CreateBlockchainRequest $request)
    {
        $this->blockchainRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('wallet::blockchains.messages.blockchain created'),
        ]);
    }

    public function find($BlockchainId)
    {
        $Blockchain = $this->blockchainRepository->find($BlockchainId);
        return new FullBlockchainTransformer($Blockchain);
    }

    public function update(Blockchain $Blockchain, UpdateBlockchainRequest $request)
    {
        $this->blockchainRepository->update($Blockchain, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('wallet::blockchains.messages.blockchain updated'),
        ]);
    }

    public function destroy(Blockchain $Blockchain)
    {
        $this->blockchainRepository->destroy($Blockchain);
        return response()->json([
            'errors' => false,
            'message' => trans('wallet::blockchains.messages.blockchain deleted'),
        ]);
    }
}
