<?php

namespace Modules\Wallet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Wallet\Entities\Blockchain;
use Modules\Wallet\Http\Requests\CreateBlockchainRequest;
use Modules\Wallet\Http\Requests\UpdateBlockchainRequest;
use Modules\Wallet\Repositories\BlockchainRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class BlockchainController extends AdminBaseController
{
    /**
     * @var BlockchainRepository
     */
    private $blockchain;

    public function __construct(BlockchainRepository $blockchain)
    {
        parent::__construct();

        $this->blockchain = $blockchain;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$blockchains = $this->blockchain->all();

        return view('wallet::admin.blockchains.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('wallet::admin.blockchains.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBlockchainRequest $request
     * @return Response
     */
    public function store(CreateBlockchainRequest $request)
    {
        $this->blockchain->create($request->all());

        return redirect()->route('admin.wallet.blockchain.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('wallet::blockchains.title.blockchains')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Blockchain $blockchain
     * @return Response
     */
    public function edit(Blockchain $blockchain)
    {
        return view('wallet::admin.blockchains.edit', compact('blockchain'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Blockchain $blockchain
     * @param  UpdateBlockchainRequest $request
     * @return Response
     */
    public function update(Blockchain $blockchain, UpdateBlockchainRequest $request)
    {
        $this->blockchain->update($blockchain, $request->all());

        return redirect()->route('admin.wallet.blockchain.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('wallet::blockchains.title.blockchains')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Blockchain $blockchain
     * @return Response
     */
    public function destroy(Blockchain $blockchain)
    {
        $this->blockchain->destroy($blockchain);

        return redirect()->route('admin.wallet.blockchain.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('wallet::blockchains.title.blockchains')]));
    }
}
