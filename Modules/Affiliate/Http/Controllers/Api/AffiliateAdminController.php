<?php

namespace Modules\Affiliate\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Affiliate\Transformers\Affiliates\AdminAffiliateTransformer;
use Modules\Affiliate\Entities\Affiliate;
use Modules\Affiliate\Enums\TypeAffiliate;
use Modules\Affiliate\Http\Requests\CreateAffiliateRequest;
use Modules\Affiliate\Http\Requests\UpdateAffiliateRequest;
use Modules\Affiliate\Repositories\AffiliateRepository;
use Modules\Affiliate\Transformers\Affiliates\FullAdminAffiliateTransformer;

class AffiliateAdminController extends Controller
{
    /**
     * @var AffiliateRepository
     */
    private $affiliateRepository;

    public function __construct(AffiliateRepository $affiliateRepository)
    {
        $this->affiliateRepository = $affiliateRepository;
    }

    public function indexServerSide(Request $request)
    {
        return AdminAffiliateTransformer::collection($this->affiliateRepository->serverPaginationFilteringFor($request));
    }

    public function quickStore(Request $request)
    {
        $floors = $request->get('floors');
        $affiliate = $this->affiliateRepository->getAffiliateLastLevel($request->get('type'));
        $i = 0;
        if ($affiliate) {
            $i = $affiliate->level + 1;
        }

        for ($k = $i; $k < $floors + $i; $k++) {
            $dataCreate = [
                'type' => $request->get('type'),
                'level' => $k,
                'commission' => 0,
                'commission_type' => 0,
                'status' => false
            ];
            $this->affiliateRepository->create($dataCreate);
        }
        return response()->json([
            'errors' => false,
            'message' => trans('affiliate::affiliates.messages.affiliate created'),
        ]);
    }


    public function store(CreateAffiliateRequest $request)
    {
        $data = $request->all();
        $affiliate = $this->affiliateRepository->getAffiliateLastLevel($request->get('type'));
        $data['level'] =   $affiliate ? $affiliate->level + 1 : 0;
        $this->affiliateRepository->create($data);

        return response()->json([
            'errors' => false,
            'message' => trans('affiliate::affiliates.messages.affiliate created'),
        ]);
    }

    public function find($affiliateId)
    {
        $affiliate = $this->affiliateRepository->find($affiliateId);
        return new FullAdminAffiliateTransformer($affiliate);
    }

    public function update($affiliateId, UpdateAffiliateRequest $request)
    {
        $affiliate = $this->affiliateRepository->find($affiliateId);
        $this->affiliateRepository->update($affiliate, [
            'commission' => $request->get('commission'),
            'commission_type' => $request->get('commission_type'),
            'status' => $request->get('status')
        ]);
        return response()->json([
            'errors' => false,
            'message' => trans('affiliate::affiliates.messages.affiliate updated'),
        ]);
    }

    public function destroy($affiliateId)
    {
        $affiliate = $this->affiliateRepository->find($affiliateId);
        $affiliateLast = $this->affiliateRepository->getAffiliateLastLevel($affiliate->type);
        if ($affiliate->id == $affiliateLast->id) {
            $this->affiliateRepository->destroy($affiliate);
            return response()->json([
                'errors' => false,
                'message' => trans('affiliate::affiliates.messages.affiliate deleted'),
            ]);
        } else {
            return response()->json([
                'errors' => true,
                'message' => trans('affiliate::affiliates.messages.cant_destroy_affiliate'),
            ]);
        }
    }

    public function getTypeAffiliate(){
        return response()->json([
            'errors' => false,
            'types' =>TypeAffiliate::cases(),
        ]);
    }
}
