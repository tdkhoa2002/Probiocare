@php
    $authCheck = auth()->guard('customer')->check();
    $isAgent = false;
    if($authCheck){
        $customer = auth()->guard('customer')->user();
        if($customer->is_agent) $isAgent = true;
    }
    $define = [
        "path_api" => url('/'),
        "pusher_channel_name" => "private-chat-".$order->id,
        "pusher_event_name" => "PeertopeerChat",
        "pusher_client_event_typing" => "client-typing",
        "box_chat" => [
            "positions" => "right",
            "margin_bottom" => "50px",
            "margin" => [
            "bottom" => "0px",
            "left" => "50px",
            "right" => "5px",
            ],
        ],
    ];
@endphp
@extends('layouts.master')

@section('title')
P2P Order| @parent
@stop
@section('content')
    <div class="payment-pending py-4 py-md-5">
        <div class="container-custom">
            <div class="d-flex justify-content-between mb-4">
                <a class="backlink " href="{{ route('fe.p2p.market.orders') }}#myorderads">
                    <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                    <div class="label">Order Detail</div>
                </a>
            </div>
        </div>
        @if($order->type =='BUY')
        <agent-order-sell-detail :order-id="{{ $order->id }}"></agent-order-sell-detail>
        @else
        <agent-order-buy-detail :order-id="{{ $order->id }}"></agent-order-buy-detail>
        @endif
        <p2p-chat-box :order-id="{{ $order->id }}" :order-my-self="{{ $customer->id }}" :define='@json($define)'></p2p-chat-box>
    </div>
@stop
