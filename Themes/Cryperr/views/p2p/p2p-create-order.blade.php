@extends('layouts.master')

@section('title')
P2P | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')
<div class="p2p-create-order py-4 py-md-5">
    <div class="container-custom">
        <div class="d-flex justify-content-between mb-4">
            <a class="backlink " href="{{ route('fe.p2p.market.agents') }}#p2p">
                <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                <div class="label">Create Order</div>
            </a>
        </div>
        @if($ads->type=='SELL')
        <create-order-buy :ads-id="{{ $ads->id }}"></create-order-buy>
        @else
        <create-order-sell :ads-id="{{ $ads->id }}"></create-order-sell>
        @endif
    </div>
</div>
@stop