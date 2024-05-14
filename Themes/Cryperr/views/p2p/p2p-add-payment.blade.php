@extends('layouts.master')

@section('title')
Add Payment | @parent
@stop

@section('content')
<div class="p2p-add-payment py-4 py-md-5">
    <div class="container-custom">
        <div class="d-flex justify-content-between mb-4">
            <a class="backlink " href="{{route('fe.p2p.market.center')}}">
                <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                <div class="label">Payment Method</div>
            </a>
        </div>
        <create-payment-method :payment-method-id="'{{ $paymentMethodID }}'"></create-payment-method>
    </div>
</div>
@stop