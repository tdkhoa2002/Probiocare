<?php

namespace Modules\Wallet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Wallet\Entities\Transaction;
use Modules\Wallet\Http\Requests\CreateTransactionRequest;
use Modules\Wallet\Http\Requests\UpdateTransactionRequest;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TransactionController extends AdminBaseController
{
    /**
     * @var TransactionRepository
     */
    private $transaction;

    public function __construct(TransactionRepository $transaction)
    {
        parent::__construct();

        $this->transaction = $transaction;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$transactions = $this->transaction->all();

        return view('wallet::admin.transactions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('wallet::admin.transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTransactionRequest $request
     * @return Response
     */
    public function store(CreateTransactionRequest $request)
    {
        $this->transaction->create($request->all());

        return redirect()->route('admin.wallet.transaction.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('wallet::transactions.title.transactions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Transaction $transaction
     * @return Response
     */
    public function edit(Transaction $transaction)
    {
        return view('wallet::admin.transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Transaction $transaction
     * @param  UpdateTransactionRequest $request
     * @return Response
     */
    public function update(Transaction $transaction, UpdateTransactionRequest $request)
    {
        $this->transaction->update($transaction, $request->all());

        return redirect()->route('admin.wallet.transaction.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('wallet::transactions.title.transactions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Transaction $transaction
     * @return Response
     */
    public function destroy(Transaction $transaction)
    {
        $this->transaction->destroy($transaction);

        return redirect()->route('admin.wallet.transaction.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('wallet::transactions.title.transactions')]));
    }
}
