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
                    <div class="swap-input swap-input_search">
                        <div class="d-flex flex-column w-100">
                            <span class="swap-input_desc">Order ID:</span>
                            <input type="text" value="{{ $order->order_code }}" required disabled />
                        </div>
                        {{-- <img class="ps-2" style="min-width: 26px;" width="18px" height="18px"
                            src="{{ Theme::url('images/search.png') }}" alt=""> --}}
                    </div>

                    <p class="swap-input_search_warning d-flex">
                        <img class="me-2" width="auto" height="24px" src="{{ Theme::url('images/icons/warning.svg') }}"
                            alt="">
                        <span>
                            For privacy reasons, Order pages are only available to
                            search & view within 48 hours after the Order was
                            created
                        </span>
                    </p>

                    <div class="swap-box swap-box_find_order">
                        <p class=" status-alert">
                            In order to initiate your swap, please send <b>{{ $order->token_send }} {{ $order->fromCurrency->coin }}</b>  on
                            <b> {{ $order->fromCurrency->network }} </b> to the wallet address displayed below
                        </p>

                        <div class="swap-box_token">
                            <p style="max-width: 720px" class="text-split text-truncate">{{ $order->address_order }}</p>
                            <div class="d-flex align-items-center">
                                <a class="copy-wrap d-flex pointer" copy-data="{{$order->address_order}}">
                                    <img class="me-3" src="{{Theme::url('images/copy.png')}}" alt="copy" />
                                    <div class="copy-notify">Success</div>
                                </a>
                                <a class="d-flex pointer" data-bs-toggle="modal" data-bs-target="#QRModal">
                                    <img class="" src="{{Theme::url('images/qr.png')}}" alt="qr" />
                                </a>
                            </div>
                        </div>

                        <div class="info-container">
                            <div class="info-box">
                                <div class="info-left">
                                    <div class="info-detail">
                                        <div class="info-text">
                                            <p>YOU SEND</p>
                                            <b>{{ $order->token_send }} {{ $order->fromCurrency->coin }} - {{
                                                $order->fromCurrency->network }} </b>
                                        </div>
                                        <div class="info-img rotateY_img">
                                            <img src="{{ $order->fromCurrency->logo }}" alt="" />
                                        </div>
                                    </div>
                                </div>

                                <div class="info-center">
                                    <img class="center-image" src="{{ Theme::url('images/arrow-find.png') }}" alt="">
                                </div>

                                <div class="info-right">
                                    <div class="info-detail">
                                        <div class="info-text">
                                            <p>YOU RECEIVED</p>
                                            <b>{{ $order->token_receive }} {{ $order->toCurrency->coin }} - {{
                                                $order->toCurrency->network }} </b>
                                        </div>
                                        <div class="info-img rotateY_img">
                                            <img src="{{ $order->toCurrency->logo }}" alt="" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="info-box1">
                                <div class="info-left1">
                                    <div class="info-sub d-flex ">
                                        <span class="text-nowrap me-2">Order ID:</span>
                                        <div class="d-flex align-items-center ">
                                            <b class="text-truncate"> {{ $order->order_code }} </b>
                                            <a class="copy-wrap" copy-data="{{$order->order_code}}">
                                                <img class="ms-2 pointer" width="auto" height="18px"
                                                    src="{{Theme::url('images/copy.png')}}" alt="copy" />
                                                <div class="copy-notify">Success</div>
                                            </a>
                                        </div>
                                    </div>
                                    <p class="info-time">
                                        <span class="me-2">Creation time:</span>
                                        <b>{{ $order->created_at }} </b>
                                    </p>
                                </div>

                                <div class="info-right1">
                                    <div class="info-sub d-flex">
                                        <span class="text-nowrap me-2">Receiver:</span>
                                        <div class="d-flex align-items-center ">
                                            <b> {{ substr($order->receive_order, 0, 5) }}...{{
                                                substr($order->receive_order, -5) }} </b>
                                            <a class="copy-wrap" copy-data="{{$order->receive_order}}">
                                                <img class="ms-2 pointer" width="auto" height="18px"
                                                    src="{{Theme::url('images/copy.png')}}" alt="copy" />
                                                <div class="copy-notify">Success</div>
                                            </a>
                                        </div>
                                    </div>
                                    {{-- <p class="info-time">
                                        <span class="me-2">Time remaining:</span>
                                        <b>07:45 </b>
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                        <div class="status-items">
                            <div class="status-item">
                                <div class="status-img rotateY_img active">
                                    <img src="{{Theme::url('images/status1.png')}}" alt="status1" />
                                </div>
                                <p class="status-name">Order Received</p>
                            </div>
                            <div class="wrap-img">
                                <img class="center-image" src="{{ Theme::url('images/arrow-find.png') }}" alt="">
                            </div>
                            <div class="status-item">
                                <div class="status-img rotateY_img active">
                                    <img src="{{Theme::url('images/status2.png')}}" alt="status2" />
                                </div>
                                <p class="status-name">Awaiting confirmations</p>
                            </div>
                            <div class="wrap-img">
                                <img class="center-image" src="{{ Theme::url('images/arrow-find.png') }}" alt="">
                            </div>
                            @if($order->status == "DONE")
                            <div class="status-item">
                                <div class="status-img rotateY_img active">
                                    <img src="{{Theme::url('images/status3.png')}}" alt="status3" />
                                </div>
                                <p class="status-name">Swapping</p>
                            </div>
                            <div class="wrap-img">
                                <img class="center-image" src="{{ Theme::url('images/arrow-find.png') }}" alt="">
                            </div>
                            <div class="status-item">
                                <div class="status-img rotateY_img active">
                                    <img src="{{Theme::url('images/status4.png')}}" alt="status4" />
                                </div>
                                <p class="status-name">Done</p>
                            </div>
                            @else
                            <div class="status-item">
                                <div class="status-img rotateY_img">
                                    <img src="{{Theme::url('images/status3.png')}}" alt="status3" />
                                </div>
                                <p class="status-name">Swapping</p>
                            </div>
                            <div class="wrap-img">
                                <img class="center-image" src="{{ Theme::url('images/arrow-find.png') }}" alt="">
                            </div>
                            <div class="status-item">
                                <div class="status-img rotateY_img">
                                    <img src="{{Theme::url('images/status4.png')}}" alt="status4" />
                                </div>
                                <p class="status-name">Done</p>
                            </div>
                            @endif
                        </div>

                        <p class="status-alert">
                            Once <b>Order Received</b> lights up, in the order displayed
                            above, your transaction is in motion. On average, it takes 20
                            minutes to arrive in your Receiving Address.
                        </p>

                        <p class="status-ask">Having trouble with your order?</p>

                        <p class="status-contact">Contact tecnical support here</p>

                        <a href="mailto:themeOption(setting('core::template', null, '').'::support_email')" class="status-telegram rotateY_img">
                            {{themeOption(setting('core::template', null, '').'::support_email')}}
                            {{-- <img src="{{Theme::url('images/telegram.png')}}" alt="telegram" /> --}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modalQrCode" id="QRModal" tabindex="-1" role="dialog" aria-labelledby="QRModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="qr-head">Address QR code</p>
                    <p class="qr-sub">(Scan in your wallet app)</p>
                    <div class="qr-big text-center">
                        <img src="https://chart.googleapis.com/chart?cht=qr&chl={{ $order->address_order }}&chs=240x240&chld=L|0" alt="qr_big">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('js')

<script>
    $(document).ready(function() {
        $('.copy-wrap').click(function(e) {
            $(this).children('div.copy-notify').css("display", "block")
            var copydata = $(this).attr('copy-data');
            navigator.clipboard.writeText(copydata).then(function () {
                alert(copydata + ' coppied!');
            }, function () {
            });
            setTimeout(() => {
                $(this).children('div.copy-notify').css("display", "none")
            }, 3000);
        })
    })
</script>
@endpush