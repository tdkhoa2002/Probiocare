@extends('layouts.private')

@section('title')
My Staking | @parent
@stop
@section('content')
<div class="my-staking py-4 py-md-5">
    <div class="my-staking-body">
        <div class="info-list mb-3 mb-md-5">
            <div class="row g-3 g-md-4">
                <div class="col-lg-6 col-xl-4">
                    <div class="info-card bg-secondary rounded-2 px-3 py-2 px-md-4 py-md-3">
                        <div class="fs-5 fs-md-4 mb-2 mb-md-4">Staking And Earn </div>
                        <a class="d-flex align-items-center text-primary fs-6 fs-md-5" href="/staking">Go to Stake <img
                                class="ms-2" width="22px" height="22px"
                                src="{{ Theme::url('images/icons/arrow-right-round-yellow.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-6 col-lg-6 col-xl-4">
                    <div class="info-card bg-secondary rounded-2 px-2 py-2 px-md-4 py-md-3 h-100">
                        <div class="text-center fs-6 fs-md-4 mb-md-4">${{$totalSystemStake}}</div>
                        <div class="text-center fs-7 fs-md-5" href="/staking">Total Staked</div>
                    </div>
                </div>
                <div class="col-6 col-lg-6 col-xl-4">
                    <div class="info-card bg-secondary rounded-2 px-2 py-2 px-md-4 py-md-3 h-100">
                        <div class="text-center fs-6 fs-md-4 mb-md-4">${{ $totalMyStake }}
                        </div>
                        <div class="text-center fs-7 fs-md-5" href="/staking">My Staked</div>
                    </div>
                </div>
                {{-- <div class="col-4 col-lg-6 col-xl-3">
                    <div class="info-card bg-secondary rounded-2 px-2 py-2 px-md-4 py-md-3 h-100">
                        <div class="text-center fs-6 fs-md-4 mb-md-4">$12.243</div>
                        <div class="text-center fs-7 fs-md-5" href="/staking">Earned Harvest</div>
                    </div>
                </div> --}}
            </div>
        </div>
        <list-my-staking></list-my-staking>
    </div>
</div>
@stop