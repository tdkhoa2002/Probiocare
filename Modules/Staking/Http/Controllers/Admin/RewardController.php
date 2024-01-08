<?php

namespace Modules\Staking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Staking\Entities\Reward;
use Modules\Staking\Http\Requests\CreateRewardRequest;
use Modules\Staking\Http\Requests\UpdateRewardRequest;
use Modules\Staking\Repositories\RewardRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class RewardController extends AdminBaseController
{
    /**
     * @var RewardRepository
     */
    private $reward;

    public function __construct(RewardRepository $reward)
    {
        parent::__construct();

        $this->reward = $reward;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$rewards = $this->reward->all();

        return view('staking::admin.rewards.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('staking::admin.rewards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRewardRequest $request
     * @return Response
     */
    public function store(CreateRewardRequest $request)
    {
        $this->reward->create($request->all());

        return redirect()->route('admin.staking.reward.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('staking::rewards.title.rewards')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Reward $reward
     * @return Response
     */
    public function edit(Reward $reward)
    {
        return view('staking::admin.rewards.edit', compact('reward'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Reward $reward
     * @param  UpdateRewardRequest $request
     * @return Response
     */
    public function update(Reward $reward, UpdateRewardRequest $request)
    {
        $this->reward->update($reward, $request->all());

        return redirect()->route('admin.staking.reward.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('staking::rewards.title.rewards')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Reward $reward
     * @return Response
     */
    public function destroy(Reward $reward)
    {
        $this->reward->destroy($reward);

        return redirect()->route('admin.staking.reward.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('staking::rewards.title.rewards')]));
    }
}
