<?php

namespace Modules\Wallet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Wallet\Entities\WalletChain;
use Modules\Wallet\Http\Requests\CreateWalletChainRequest;
use Modules\Wallet\Http\Requests\UpdateWalletChainRequest;
use Modules\Wallet\Repositories\WalletChainRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class WalletChainController extends AdminBaseController
{
    /**
     * @var WalletChainRepository
     */
    private $walletchain;

    public function __construct(WalletChainRepository $walletchain)
    {
        parent::__construct();

        $this->walletchain = $walletchain;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$walletchains = $this->walletchain->all();

        return view('wallet::admin.walletchains.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('wallet::admin.walletchains.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWalletChainRequest $request
     * @return Response
     */
    public function store(CreateWalletChainRequest $request)
    {
        $this->walletchain->create($request->all());

        return redirect()->route('admin.wallet.walletchain.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('wallet::walletchains.title.walletchains')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  WalletChain $walletchain
     * @return Response
     */
    public function edit(WalletChain $walletchain)
    {
        return view('wallet::admin.walletchains.edit', compact('walletchain'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WalletChain $walletchain
     * @param  UpdateWalletChainRequest $request
     * @return Response
     */
    public function update(WalletChain $walletchain, UpdateWalletChainRequest $request)
    {
        $this->walletchain->update($walletchain, $request->all());

        return redirect()->route('admin.wallet.walletchain.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('wallet::walletchains.title.walletchains')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  WalletChain $walletchain
     * @return Response
     */
    public function destroy(WalletChain $walletchain)
    {
        $this->walletchain->destroy($walletchain);

        return redirect()->route('admin.wallet.walletchain.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('wallet::walletchains.title.walletchains')]));
    }
}
