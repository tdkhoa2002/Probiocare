@extends('layouts.private')

@section('title')
Wallet History | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')
<div class="wallet-history">
    <div class="d-flex justify-content-between mb-4">
        <a class="backlink " href="/wallet">
            <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
            <div class="label">History</div>
        </a>
    </div>

    <form action="{{ route('fe.wallet.wallet.history') }}" method="GET" class="form-wallet-history row g-2 g-lg-3 mb-4">
        <div class="col-12">
            <div class="form-item mb-0">
                <label for="currency" class="form-label">
                    Transaction Txh
                </label>
                <input type="text" class="input secondary" placeholder="Search Txh" name="tx" value="{{ request()->get('tx') }}">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="form-item mb-0">
                <label for="currency" class="form-label">
                    Network
                </label>

                <select class="input secondary" data-theme="default secondary" data-placeholder="Select network"
                    name="network">
                    <option selected value="">ALL</option>
                    @foreach ($blockchains as $blockchain)
                    <option value="{{ $blockchain->id }}" {{ request()->get('network')== $blockchain->id
                        ?'selected':""}}>
                        {{ $blockchain->code }} ({{ $blockchain->title }})
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="form-item mb-0">
                <label for="currency" class="form-label">
                    Action
                </label>
                <select class="input secondary" data-theme="default secondary" data-placeholder="Select Action"
                    name="action">
                    <option selected value="">ALL</option>
                    @foreach ($types as $type)
                    <option value="{{ $type }}" {{ request()->get('action')==$type ?'selected':""}}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="form-item mb-0">
                <label for="currency" class="form-label">
                    Currency
                </label>
                <select class="input secondary" data-theme="default secondary" data-placeholder="Select currency"
                    name="currency">
                    <option selected value="">All</option>
                    @foreach ($currencies as $currency)
                    <option value="{{ $currency->id }}" {{ request()->get('currency')== $currency->id ?'selected':""}}>
                        {{ $currency->code }} ({{ $currency->title }})
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="form-item mb-0">
                <label for="currency" class="form-label">
                    Search now
                </label>
                <button class="btn btn-primary secondary" type="submit" style="width:100%;">Search</button>
            </div>
        </div>
    </form>
    @include('partials.recent-transaction')
</div>
@stop