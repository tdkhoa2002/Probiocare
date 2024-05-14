@php
@endphp
@extends('layouts.master')

@section('title')
{{ __('shopping.title_checkout') }} | @parent
@stop

@section('content')
<main>
    <div class="blog-detail container-custom">
        <div class="d-flex justify-content-between my-3">
            <a class="backlink " href="{{ route('fe.product.product.list') }}">
                <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                <div class="label">{{ __('shopping.checkout_label') }}</div>
            </a>
        </div>
    </div>
    <form action="
    {{-- {{ route('fe.shoppingcart.buyProductWeb3') }} --}}
    " method="POST" id="form_checkout">
        @csrf
        <section class="box-carts container-custom">
            <div class="row">
                <div class="">
                    <div class="box-info-cart">
                        <h3>{{ __('shopping.your_order') }}</h3>
                        <div class="box-info sub-total">
                            <div>{{ __('shopping.subtotal') }}</div>
                            <div class="price"><span>{{ $subtotal }}</span>$</div>
                        </div>
                        <div class="box-info">
                            <div>{{ __('shopping.pay_plc') }}</div>
                            <div>{{ $plc }}$</div>
                        </div>
                        <hr>
                        <div class="box-info total-payment">
                            <div>{{ __('shopping.total_payment') }}</div>
                            <div class="price"><span>{{ $total }}</span>$</div>
                        </div>
                        <div class="action">
                            <a class="btn btn-primary" style="margin-right: 50px; width: 300px;" href="{{ route('fe.shoppingcart.processTransaction') }}">Pay with Paypal</a>
                            @if(\Session::has('error'))
                                <div class="alert alert-danger">{{ \Session::get('error') }}</div> 
                                {{ \Session::forget('error') }}
                            @endif
                            @if(\Session::has('success'))
                                <div class="alert alert-success">{{ \Session::get('success') }}</div> 
                                {{ \Session::forget('success') }}
                            @endif
                            <connect-wallet></connect-wallet>
                            <a style="margin-top: 30px;" href="/products">{{ __('shopping.continue_shopping') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
@stop