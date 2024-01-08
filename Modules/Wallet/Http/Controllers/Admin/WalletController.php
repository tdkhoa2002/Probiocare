<?php

namespace Modules\Wallet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Http\Requests\CreateWalletRequest;
use Modules\Wallet\Http\Requests\UpdateWalletRequest;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class WalletController extends AdminBaseController
{
    /**
     * @var WalletRepository
     */
    private $wallet;

    public function __construct(WalletRepository $wallet)
    {
        parent::__construct();

        $this->wallet = $wallet;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$wallets = $this->wallet->all();

        return view('wallet::admin.wallets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('wallet::admin.wallets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWalletRequest $request
     * @return Response
     */
    public function store(CreateWalletRequest $request)
    {
        $this->wallet->create($request->all());

        return redirect()->route('admin.wallet.wallet.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('wallet::wallets.title.wallets')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Wallet $wallet
     * @return Response
     */
    public function edit(Wallet $wallet)
    {
        return view('wallet::admin.wallets.edit', compact('wallet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Wallet $wallet
     * @param  UpdateWalletRequest $request
     * @return Response
     */
    public function update(Wallet $wallet, UpdateWalletRequest $request)
    {
        $this->wallet->update($wallet, $request->all());

        return redirect()->route('admin.wallet.wallet.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('wallet::wallets.title.wallets')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Wallet $wallet
     * @return Response
     */
    public function destroy(Wallet $wallet)
    {
        $this->wallet->destroy($wallet);

        return redirect()->route('admin.wallet.wallet.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('wallet::wallets.title.wallets')]));
    }
}
