<?php

namespace Modules\Wallet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Wallet\Entities\TransactionCode;
use Modules\Wallet\Http\Requests\CreateTransactionCodeRequest;
use Modules\Wallet\Http\Requests\UpdateTransactionCodeRequest;
use Modules\Wallet\Repositories\TransactionCodeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TransactionCodeController extends AdminBaseController
{
    /**
     * @var TransactionCodeRepository
     */
    private $transactioncode;

    public function __construct(TransactionCodeRepository $transactioncode)
    {
        parent::__construct();

        $this->transactioncode = $transactioncode;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$transactioncodes = $this->transactioncode->all();

        return view('wallet::admin.transactioncodes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('wallet::admin.transactioncodes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTransactionCodeRequest $request
     * @return Response
     */
    public function store(CreateTransactionCodeRequest $request)
    {
        $this->transactioncode->create($request->all());

        return redirect()->route('admin.wallet.transactioncode.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('wallet::transactioncodes.title.transactioncodes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TransactionCode $transactioncode
     * @return Response
     */
    public function edit(TransactionCode $transactioncode)
    {
        return view('wallet::admin.transactioncodes.edit', compact('transactioncode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TransactionCode $transactioncode
     * @param  UpdateTransactionCodeRequest $request
     * @return Response
     */
    public function update(TransactionCode $transactioncode, UpdateTransactionCodeRequest $request)
    {
        $this->transactioncode->update($transactioncode, $request->all());

        return redirect()->route('admin.wallet.transactioncode.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('wallet::transactioncodes.title.transactioncodes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TransactionCode $transactioncode
     * @return Response
     */
    public function destroy(TransactionCode $transactioncode)
    {
        $this->transactioncode->destroy($transactioncode);

        return redirect()->route('admin.wallet.transactioncode.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('wallet::transactioncodes.title.transactioncodes')]));
    }
}
