<?php

namespace Modules\Staking\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Staking\Repositories\OrderRepository;

class ReportController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function reportTotal()
    {
        $allOrder = $this->orderRepository->all();
        $totalStake = $allOrder->count();
        $totalValueStake = $allOrder->sum('amount_usd_stake');
        $totalValueReward = $allOrder->sum('total_amount_reward');
        return response()->json([
            'totalStake' => $totalStake,
            'totalValueStake' => $totalValueStake,
            'totalValueReward' => $totalValueReward
        ]);
    }
}
