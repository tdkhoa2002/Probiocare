@extends('layouts.master')

@section('title')
    P2P Agent Profile | @parent
@stop
@section('content')
<div class="p2p-bank py-4 py-md-5">
    <div class="p2p-bank-body">
        <div class="p2p-tab-main tabs">
            <div class="tab-content">
                <div class="tab-pane active" id="p2puser" role="tabpanel" tabindex="2">
                    @include('p2p.agents.p2p-agent-profile')

                    <div class="container-fluid">
                        <div class="tab-order tabs">
                            <div class="tabs-header">
                                <ul class="tab-order-list nav nav-tabs" id="order-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link " data-bs-toggle="tab" data-bs-target="#paymentMethod" type="button" role="tab">
                                            Payment Methods
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#postAds" type="button" role="tab">
                                            Online Ads
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane " id="paymentMethod" role="tabpanel" tabindex="3">
                                    @include('p2p.agents.p2p-agent-payment-methods')
                                </div>
                                <div class="tab-pane active" id="postAds" role="tabpanel" tabindex="4">
                                    @include('p2p.agents.p2p-agent-ads')
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@stop