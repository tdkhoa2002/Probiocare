@extends('layouts.master')

@section('title')
P2P | @parent
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
            <p2p-all-market-ads :currencies="{{$currencies}}" :payment-methods="{{$paymentMethods}}">
            </p2p-all-market-ads>
        </div>
    </div>
</div>
@stop