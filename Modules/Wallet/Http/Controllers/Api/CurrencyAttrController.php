<?php

namespace Modules\Wallet\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Wallet\Entities\CurrencyAttr;
use Modules\Wallet\Http\Requests\CreateCurrencyAttrRequest;
use Modules\Wallet\Http\Requests\UpdateCurrencyAttrRequest;
use Modules\Wallet\Repositories\CurrencyAttrRepository;
use Modules\Wallet\Transformers\CurrencyAttrs\FullCurrencyAttrTransformer;
use Modules\Wallet\Transformers\CurrencyAttrs\CurrencyAttrTransformer;
use Modules\Wallet\Repositories\CurrencyRepository;

class CurrencyAttrController extends Controller
{
    /**
     * @var CurrencyAttrRepository
     */
    private $currencyAttrRepository;
    private $currencyRepository;

    public function __construct(
        CurrencyAttrRepository $currencyAttrRepository,
        CurrencyRepository $currencyRepository
    ) {
        $this->currencyAttrRepository = $currencyAttrRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function listByCurrency($currencyId)
    {
        $currency = $this->currencyRepository->find($currencyId);
        if (!$currency) {
            return response()->json([
                'errors' => true,
                'message' => trans('wallet::currencies.messages.currency_not_found'),
            ]);
        }
        $currencyAttrs = $this->currencyAttrRepository->getByAttributes(['currency_id' => $currencyId]);
        return CurrencyAttrTransformer::collection($currencyAttrs);
    }

    public function store($currencyId, CreateCurrencyAttrRequest $request)
    {
        $currency = $this->currencyRepository->find($currencyId);
        if (!$currency) {
            return response()->json([
                'errors' => true,
                'message' => trans('wallet::currencies.messages.currency_not_found'),
            ]);
        }
        $checkData = $this->currencyAttrRepository->findByAttributes(['blockchain_id' => $request->get('blockchain_id'), 'currency_id' => $currencyId]);
        if ($checkData) {
            return response()->json([
                'errors' => true,
                'message' => trans('wallet::currencyattrs.messages.currency_attr_esxit'),
            ]);
        }
        $data = $request->all();
        $data['currency_id'] = $currencyId;
        $this->currencyAttrRepository->create($data);

        return response()->json([
            'errors' => false,
            'message' => trans('wallet::currencyattrs.messages.currencyattr created'),
        ]);
    }

    public function find($currencyAttrId)
    {
        $currencyAttrId = $this->currencyAttrRepository->find($currencyAttrId);
        return new FullCurrencyAttrTransformer($currencyAttrId);
    }

    public function update($currencyId, $currencyAttrId, UpdateCurrencyAttrRequest $request)
    {
        $currency = $this->currencyRepository->find($currencyId);
        if (!$currency) {
            return response()->json([
                'errors' => true,
                'message' => trans('wallet::currencies.messages.currency_not_found'),
            ]);
        }
        $currencyAttr = $this->currencyAttrRepository->find($currencyAttrId);
        if (!$currencyAttr) {
            return response()->json([
                'errors' => true,
                'message' => trans('wallet::currencyattrs.messages.currency_attr_not_found'),
            ]);
        }
        $this->currencyAttrRepository->update($currencyAttr, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('wallet::currencyattrs.messages.currencyattr updated'),
        ]);
    }

    public function destroy($currencyAttrId)
    {
        try {
            $currencyAttr = $this->currencyAttrRepository->find($currencyAttrId);
            if (!$currencyAttr) {
                return response()->json([
                    'errors' => true,
                    'message' => trans('wallet::currencies.messages.currency_attr_not_found'),
                ]);
            }
            $this->currencyAttrRepository->destroy($currencyAttr);
            return response()->json([
                'errors' => false,
                'message' => trans('wallet::currencyattrs.messages.currencyattr deleted'),
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'errors' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
