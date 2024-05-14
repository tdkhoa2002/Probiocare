@extends('layouts.private')

@section('title')
Affiliate | @parent
@stop

@section('content')

<section class="box-wrapper-affiliate">
    <div class="box-sumary-affiliate row">
        <div class=" col-12 col-md-6 col-lg-3">
            <div class="item">
                <h3>${{ $totalCommissionTrade }}</h3>
                <h4>Trade Commission</h4>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="item">
                <h3>${{ $totalCommissionStaking }}</h3>
                <h4>Stake Commission</h4>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="item">
                <h3>${{ $totalCommissionDeposit }}</h3>
                <h4>Deposit Commission</h4>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
            <div class="item">
                <h3>{{ $totalDirectMember }}</h3>
                <h4>Total Direct Members</h4>
            </div>
        </div>
    </div>
    <div class="box-ref-link">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="link">
                    <div class="group-input-custom">
                        <input type="text" class="input secondary" readonly
                            value="{{ route('fe.customer.customer.register') }}?ref={{ $customer->ref_code }}"> <a
                            class="copy-wrap d-flex align-items-center ms-3">
                            <img width="32px" height="32px" src="{{ Theme::url('images/icon-copy.png') }}" alt=""
                                class="icon" style="min-width: 32px;">
                            <div class="copy-notify" style="display: none;">Success</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="code">
                    <div class="group-input-custom"><input type="text" class="input secondary" readonly
                            value="{{ $customer->ref_code }}"> <a class="copy-wrap d-flex align-items-center ms-3">
                            <img width="32px" height="32px" src="{{ Theme::url('images/icon-copy.png') }}" alt=""
                                class="icon" style="min-width: 32px;">
                            <div class="copy-notify" style="display: none;">Success</div>
                        </a></div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop