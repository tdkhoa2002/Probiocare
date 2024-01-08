@extends('layouts.master')

@section('title')
{{ $page->title }} | @parent
@stop

@section('meta')
<meta name="title" content="{{ $page->meta_title}}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop

@section('content')
<div class="container-fluid">
    <div class="swap-wrapper index-wrapper">
        <div class="wrap-content">
            <ul class="nav nav-tabs swap-ul" role="tablist">
                <li class="swap-li" role="presentation">
                    <a class="active" href="#">Swap</a>
                </li>
                <li class="swap-li" role="presentation">
                    <a class="" href="{{route('fe.cryperrswap.getFindOrder')}}">Find</a>
                </li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="swap">
                    <cryperr-swap></cryperr-swap>
                </div>
            </div>
        </div>
    </div>
    <section class="mb-5">
        <hr>
        <div class="row g-3 g-lg-5 m-1">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card-total-info">
                    <h1 class="text-primary">{{themeOption(setting('core::template', null, '').'::registered_user')}}</h1>
                    <h5><span class="text-primary">//</span> Active Users</h5>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card-total-info">
                    <h1 class="text-primary">{{themeOption(setting('core::template', null, '').'::transaction_fee')}}</h1>
                    <h5><span class="text-primary">//</span> Lowest Fee</h5>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card-total-info">
                    <h1 class="text-primary">{{themeOption(setting('core::template', null, '').'::cryptocurrencies')}}</h1>
                    <h5><span class="text-primary">//</span> Cryptocurrencies</h5>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card-total-info">
                    <h1 class="text-primary">{{themeOption(setting('core::template', null, '').'::trading_pairs')}}</h1>
                    <h5><span class="text-primary">//</span> Swap Pairs</h5>
                </div>
            </div>
        </div>
    </section>
    {{-- <div class="modal fade chain-modal" id="selectChainModal" tabindex="-1" role="dialog"
        aria-labelledby="selectChainModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="select-wrapper token-wrapper">
                        <div class="wrap-content">
                            <div class="select-box">
                                <p class="select-title">Select Chain</p>

                                <div class="select-input">
                                    <img class="me-2" width="20px" height="20px"
                                        src="{{ Theme::url('images/search.png') }}" alt="">
                                    <input type="text" placeholder="Search by name or chain ID">
                                </div>

                                <div class="select-items">
                                    <div class="select-item">
                                        <div class="select-img">
                                            <img src="{{ Theme::url('images/select.png') }}" alt="">
                                        </div>
                                        <div class="select-info">
                                            <p class="select-name">UDOGE</p>
                                            <p class="select-desc">UKA DOGE COIN</p>
                                        </div>
                                    </div>
                                    <div class="select-item">
                                        <div class="select-img">
                                            <img src="{{ Theme::url('images/select.png') }}" alt="">
                                        </div>
                                        <div class="select-info">
                                            <p class="select-name">UDOGE</p>
                                            <p class="select-desc">UKA DOGE COIN</p>
                                        </div>
                                    </div>
                                    <div class="select-item">
                                        <div class="select-img">
                                            <img src="{{ Theme::url('images/select.png') }}" alt="">
                                        </div>
                                        <div class="select-info">
                                            <p class="select-name">UDOGE</p>
                                            <p class="select-desc">UKA DOGE COIN</p>
                                        </div>
                                    </div>
                                    <div class="select-item">
                                        <div class="select-img">
                                            <img src="{{ Theme::url('images/select.png') }}" alt="">
                                        </div>
                                        <div class="select-info">
                                            <p class="select-name">UDOGE</p>
                                            <p class="select-desc">UKA DOGE COIN</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="select-btn" data-dismiss="modal">
                                    <p data-bs-dismiss="modal" aria-label="Close">close</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>

@stop