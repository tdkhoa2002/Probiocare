@extends('layouts.master')

@section('title')
TXN | @parent
@stop

@section('content')
<div class="txn container-fluid">
    <div class="mm-page mm-slideout" id="mm-0">
        <div class="swap-wrapper find-wrapper">
            <div class="wrap-content">
                <ul class="nav nav-tabs swap-ul" role="tablist">
                    <li role="presentation" class="swap-li">
                        <a class="  " href="/">Swap</a>
                    </li>
                    <li role="presentation" class="swap-li active">
                        <a class="active" href="#find" aria-controls="all" role="tab" data-toggle="tab">Find</a>
                    </li>
                </ul>

                <!-- Find order -->
                <div role="tabpanel" class="tab-pane" id="find">
                    <form method="GET">
                        <div class="swap-input swap-input_search">
                            <div class="d-flex flex-column w-100">
                                <span class="swap-input_desc">Order ID:</span>
                                <input name="code" type="text" value="" required />
                            </div>
                            {{-- <img class="ps-2" style="min-width: 26px;" width="18px" height="18px"
                                src="{{ Theme::url('images/search.png') }}" alt=""> --}}
                        </div>
                        <div class="swap-input_search">
                            <button class="btn btn-primary" type="submit" style="width: 100%">Find</button>
                        </div>
                    </form>

                    <p class="swap-input_search_warning d-flex">
                        <img class="me-2" width="auto" height="24px" src="{{ Theme::url('images/icons/warning.svg') }}"
                            alt="">
                        <span>
                            For privacy reasons, Order pages are only available to
                            search & view within 48 hours after the Order was
                            created
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@stop