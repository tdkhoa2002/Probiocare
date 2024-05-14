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
if($customer->is_agent) $isAgent = true;
}
@endphp
@section('content')
<div class="p2p-bank py-4 py-md-5">
    <div class="p2p-bank-body">
        <div class="p2p-tab-main tabs">
            @include('partials.p2p.nav')
            @if($authCheck)
            <div class="container-fluid py-4">
                <div class="tab-order tabs">
                    <div class="tabs-header">
                        <ul class="tab-order-list nav nav-tabs" id="order-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#myorders" type="button"
                                    href="#myorders" role="tab">
                                    My Orders
                                </a>
                            </li>
                            @if($isAgent)
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#myorderads" type="button"
                                    href="#myorderads" role="tab">
                                    My Ads' Orders
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="myorders" role="tabpanel" tabindex="3">
                            <p2p-my-orders></p2p-my-orders>
                        </div>
                        @if($isAgent)
                        <div class="tab-pane" id="myorderads" role="tabpanel" tabindex="4">
                            <list-agent-order></list-agent-order>
                        </div>
                        @endif
                    </div>

                </div>

            </div>
            @endif
        </div>
    </div>
</div>
@stop