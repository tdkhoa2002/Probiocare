@extends('layouts.private')

@section('title')
Deposit | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')

<div class="deposit">
    <div class="d-flex justify-content-between mb-4">
        <a class="backlink " href="{{ route('fe.wallet.wallet.list') }}">
            <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
            <div class="label">Deposit</div>
        </a>
    </div>
    <wallet-get-address :currency_id="{{ $currencyIdSelected }}"></wallet-get-address>
    

    {{-- <div class="d-flex justify-content-between mb-4" style="max-width: 520px">
        <div class="d-flex flex-column">
            <div class="fw-light">Expected arrival</div>
            <div class="text">15 network confirmations</div>
        </div>
        <div class="d-flex flex-column">
            <div class="fw-light">Expected unlock</div>
            <div class="text">15 network confirmations</div>
        </div>
    </div> --}}
</div>
@stop