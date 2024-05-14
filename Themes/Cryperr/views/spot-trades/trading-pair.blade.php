@extends('layouts.master')

@section('title')
{{$symbol}} Trading | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title}}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')

<div class="trading-pair">
    @php
    $checkAuth = auth()->guard('customer')->check();
    $customerID = auth()->guard('customer')->user()->id ?? null;

    @endphp
    <trading-pair-detail :customer="{{$customerID}}" pairsymbol="{{$symbol}}" :check-auth="{!! $checkAuth ==false ?"
        false":"true" !!}" link-login="{{ route('fe.customer.customer.login') }}"
        link-register="{{ route('fe.customer.customer.register') }}"
        link-route="{{ config('app.url') }}"></trading-pair-detail>
</div>
@stop