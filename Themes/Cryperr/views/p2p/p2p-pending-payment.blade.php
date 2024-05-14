@extends('layouts.master')

@section('title')
    Add Payment | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}
@php
    $step = 1;
@endphp

@section('content')
    <div class="payment-pending py-4 py-md-5">
        <div class="container-custom">
            <div class="d-flex justify-content-between mb-4">
                <a class="backlink " href="/p2p-create-ads">
                    <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                    <div class="label">Order Detail</div>
                </a>
            </div>
        </div>
        @if ($step == 1)
            <div class="order-pending-payment ">
                <div class="bg-secondary py-4">
                    <div class="container-custom">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <button class="btn btn-danger me-3" style="min-width: 120px">Sell</button>
                            <div class="fw-medium fs-4">Sell USDT</div>
                        </div>
                        <div class="d-flex justify-content-between flex-column flex-md-row">
                            <div class="d-flex align-items-center flex-column flex-md-row mb-4 mb-md-0">
                                <div class="fw-light me-3">The order is created, please wait for system confirmation</div>
                                <div class="countdown mt-3 mt-md-0">
                                    <span class="count me-2">1</span>
                                    <span class="count">0</span>
                                    <span class="colon mx-2">:</span>
                                    <span class="count">1</span>
                                    <span class="count ms-2">9</span>
                                </div>
                            </div>

                            <div class="ms-3">
                                <div class="d-flex align-items-center mb-2 mb-md-0">
                                    <span class="fw-light me-2">Order number:</span>
                                    0495748923223
                                    <a class="copy-wrap ms-2">
                                        <img class="pointer" width="24px" height="24px"  src="{{ Theme::url('images/icons/copy.png') }}" alt="" />
                                        <div class="copy-notify">Success</div>
                                    </a>
                                </div>
                                <div class="">
                                    <span class="fw-light me-2">Time created:</span>
                                    2023/05/05 16:09:45
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-custom py-3 mt-3 mt-md-5 mb-4">
                    <ul class="progressbar d-none d-md-flex mb-5">
                        <li class="complete">Pending Payment <span class="round"></span> </li>
                        <li class="active">Release of Crypto Assets <span class="round"></span></li>
                        <li>Completed <span class="round"></span></li>
                    </ul>
                    <ul class="progressbar vertical d-flex d-md-none mb-4">
                        <li class="complete">Pending Payment <span class="round"></span> </li>
                        <li class="active">Release of Crypto Assets <span class="round"></span></li>
                        <li>Completed <span class="round"></span></li>
                    </ul>

                    <div class="fw-medium fs-5 mb-1 mb-md-3">
                        Order info
                    </div>
                    <div class="d-flex justify-content-between justify-content-md-start mb-4 mb-md-3">
                        <div class="d-flex flex-column me-5">
                            <div class="mb-2">Amount</div>
                            <div class="fw-medium fs-5">
                                $ 1000
                            </div>
                        </div>
                        <div class="d-flex flex-column me-5">
                            <div class="mb-2">Price</div>
                            <div class="fw-medium fs-5">
                                $ 1000
                            </div>
                        </div>
                        <div class="d-flex flex-column ">
                            <div class="mb-2">Quantity</div>
                            <div class="fw-medium fs-5">
                                $ 1000
                            </div>
                        </div>
                    </div>

                    <div class="fw-medium fs-5 mb-3">
                        Payment Method
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <img class="me-2" width="24px" height="24px" src="{{ Theme::url('images/bank.png') }}"
                            alt="">
                        <span class="fw-medium">Bank Transfer</span>
                    </div>

                    {{-- Dekstop --}}
                    <div class="wrap-table mb-3 d-none d-md-block">
                        <table class="table" style="min-width: 500px">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Bank Account</th>
                                    <th scope="col">Bank Name</th>
                                    <th scope="col ">
                                        <div class="text-end">Open Branch</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center ">
                                            <div class="fw-medium me-3">John Olsen</div>
                                            <a class="copy-wrap">
                                                <img class="pointer" width="24px" height="24px"  src="{{ Theme::url('images/icons/copy.png') }}" alt="" />
                                                <div class="copy-notify">Success</div>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center ">
                                            <div class="fw-medium me-3">218 5192430</div>
                                            <a class="copy-wrap">
                                                <img class="pointer" width="24px" height="24px"  src="{{ Theme::url('images/icons/copy.png') }}" alt="" />
                                                <div class="copy-notify">Success</div>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center ">
                                            <div class="fw-medium me-3">VP Bank</div>
                                            <a class="copy-wrap">
                                                <img class="pointer" width="24px" height="24px"  src="{{ Theme::url('images/icons/copy.png') }}" alt="" />
                                                <div class="copy-notify">Success</div>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-end fw-medium">Ho Chi Minh</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                   {{-- Mobile --}}
                    <div class="mobile-table-list d-block d-md-none mb-4">
                        <div class="col-item border-bottom py-3">
                            <div class="d-flex justify-content-between mb-3">
                                <div >
                                    Name :
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="email  fw-medium me-2">JohnOlsen</span>
                                    <img class="pointer" width="24px" height="24px" src="{{ Theme::url('images/icons/copy.png') }}" alt="">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div >
                                    Bank Account :
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="email  fw-medium me-2">218 5192430</span>
                                    <img class="pointer" width="24px" height="24px" src="{{ Theme::url('images/icons/copy.png') }}" alt="">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div >
                                    Bank Name :
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="email  fw-medium me-2">VP Bank</span>
                                    <img class="pointer" width="24px" height="24px" src="{{ Theme::url('images/icons/copy.png') }}" alt="">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div >
                                    Open Branch :
                                </div>
                                <div class="email  fw-medium me-2">Ho Chi Minh</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex">
                        <button class="btn btn-outline me-3">Appeals</button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPaymentConfirm">Payment Received</button>
                    </div>
                </div>
            </div>
        @endif

        @if ($step == 2)
            <div class="order-pending-payment">
                <div class="bg-secondary py-4">
                    <div class="container-custom">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <button class="btn btn-danger me-3" style="min-width: 120px">Sell</button>
                            <div class="fw-medium fs-4">Order Completed</div>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-center  mb-3 mb-md-0">
                                <div class="fw-light me-3">
                                    <span class="fw-light">You have successfully sold:</span>
                                    <span class="text">998.7 USDT</span>
                                    
                                </div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center">
                                    <span class="fw-light me-2">Order number:</span>0495748923223
                                    <img class="ms-2" width="24px" height="24px"
                                        src="{{ Theme::url('images/icons/copy.png') }}" alt="">
                                </div>
                                <div>
                                    <span class="fw-light me-2">Time created:</span>2023/05/05 16:09:45
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-custom py-3 mt-3 mt-md-4 mb-4">
                    <ul class="progressbar d-none d-md-flex mb-5">
                        <li class="complete">Pending Payment <span class="round"></span> </li>
                        <li class="active">Release of Crypto Assets <span class="round"></span></li>
                        <li>Completed <span class="round"></span></li>
                    </ul>
                    <ul class="progressbar vertical d-flex d-md-none mb-4">
                        <li class="complete">Pending Payment <span class="round"></span> </li>
                        <li class="active">Release of Crypto Assets <span class="round"></span></li>
                        <li>Completed <span class="round"></span></li>
                    </ul>

                    <div class="secondary-card">
                        <div class="d-flex justify-content-center flex-column align-items-center">
                            <div class="text-success fs-4 fw-medium mb-2">Order Successfully</div>
                            <p class="fw-light mb-4">Your order has been completed, please check your balance
                            </p>
                            <img class="mb-4" width="190px" height="190px"
                                src="{{ Theme::url('images/docs-success.png') }}" alt="">
                            <button class="btn btn-primary">Check My balance</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @include('partials.p2p.modal-payment-confirm')
        @include('partials.modal-verify-code')
    </div>
@stop
