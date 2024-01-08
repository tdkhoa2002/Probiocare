@extends('layouts.master')

@section('title')
Spot Trades | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')
<div class="trading py-4 py-md-5">
    <div class="container-fluid">
        <div class="backlink pb-2 pb-md-4">
            <div class="d-flex align-items-center">
                <div class="label">Trading Pairs</div>
            </div>
        </div>
        <div class="trading-content">
            {{-- <div class="d-flex justify-content-between md-2 mb-md-4">
                <div class="filter-header">
                    <a class="fs-6">All</a>
                    <a class="active">Favorites</a>
                </div>

                <div class="right-search">
                    <div class="input-group" onclick="handleShowSearchInputTradingPair(this)">
                        <img src="{{ Theme::url('images/icon-search.png') }}" alt="" width="24px" height="24px">
                        <input class="input" id="tradingPairSearch" type="text" placeholder="Search Coin Name">
                    </div>
                    <script>
                        function handleShowSearchInputTradingPair() {
                                if (window.innerWidth < 576) {
                                    $('#tradingPairSearch').css('display', 'block')
                                }
                            }
                    </script>
                </div>
            </div> --}}
            <trading-pair-list></trading-pair-list>
        </div>
    </div>
</div>
@stop