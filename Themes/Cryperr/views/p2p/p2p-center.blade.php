@extends('layouts.master')

@section('title')
P2P Center| @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}
@php
$authCheck = auth()->guard('customer')->check();
$isAgent = false;
if($authCheck){
$customer = auth()->guard('customer')->user();
$ads = $customer->ads;
if($customer->is_agent) $isAgent = true;
}
@endphp
@section('content')
<div class="p2p-bank py-4 py-md-5">
    <div class="p2p-bank-body">
        <div class="p2p-tab-main tabs">
            @include('partials.p2p.nav')
            @if($authCheck)
            @include('p2p.p2p-agent-profile', compact('isAgent'))
            <div class="container-fluid">
                <div class="tab-order tabs">
                    <div class="tabs-header">
                        <ul class="tab-order-list nav nav-tabs" id="order-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#paymentMethod" type="button" href="#paymentMethod"
                                    role="tab">
                                    Payment Methods
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#postAds" type="button" href="#postAds"
                                    role="tab">
                                    Online Ads
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="paymentMethod" role="tabpanel" tabindex="3">
                            @include('p2p.p2p-my-payment-methods', compact('paymentMethods'))
                        </div>
                        <div class="tab-pane" id="postAds" role="tabpanel" tabindex="4">
                            @include('p2p.p2p-my-ads')
                        </div>
                    </div>

                </div>

            </div>
            @endif
        </div>
    </div>
</div>
@stop