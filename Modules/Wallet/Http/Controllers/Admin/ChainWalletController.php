<?php

namespace Modules\Wallet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Wallet\Entities\ChainWallet;
use Modules\Wallet\Http\Requests\CreateChainWalletRequest;
use Modules\Wallet\Http\Requests\UpdateChainWalletRequest;
use Modules\Wallet\Repositories\ChainWalletRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ChainWalletController extends AdminBaseController
{
    /**
     * @var ChainWalletRepository
     */
    private $chainwallet;

    public function __construct(ChainWalletRepository $chainwallet)
    {
        parent::__construct();

        $this->chainwallet = $chainwallet;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$chainwallets = $this->chainwallet->all();

        return view('wallet::admin.chainwallets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('wallet::admin.chainwallets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateChainWalletRequest $request
     * @return Response
     */
    public function store(CreateChainWalletRequest $request)
    {
        $this->chainwallet->create($request->all());

        return redirect()->route('admin.wallet.chainwallet.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('wallet::chainwallets.title.chainwallets')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ChainWallet $chainwallet
     * @return Response
     */
    public function edit(ChainWallet $chainwallet)
    {
        return view('wallet::admin.chainwallets.edit', compact('chainwallet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ChainWallet $chainwallet
     * @param  UpdateChainWalletRequest $request
     * @return Response
     */
    public function update(ChainWallet $chainwallet, UpdateChainWalletRequest $request)
    {
        $this->chainwallet->update($chainwallet, $request->all());

        return redirect()->route('admin.wallet.chainwallet.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('wallet::chainwallets.title.chainwallets')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ChainWallet $chainwallet
     * @return Response
     */
    public function destroy(ChainWallet $chainwallet)
    {
        $this->chainwallet->destroy($chainwallet);

        return redirect()->route('admin.wallet.chainwallet.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('wallet::chainwallets.title.chainwallets')]));
    }
}
