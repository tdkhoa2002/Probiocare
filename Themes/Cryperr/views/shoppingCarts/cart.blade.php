@extends('layouts.master')

@section('title')
Carts | @parent
@stop

@section('content')
<main>
    <div class="blog-detail container-custom">
        <div class="d-flex justify-content-between my-3">
            <a class="backlink " href="{{ route('homepage') }}">
                <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                <div class="label">Your Cart</div>
            </a>
        </div>
    </div>
    <section class="box-carts container-custom">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="box-table-cart">
                    <div class="table-title">
                        <img class="pointer" src="{{ Theme::url('images/icons/icon-shop.png') }}" alt="">
                        <span>Order Summary</span>
                    </div>
                    <div class="box-table">
                        <ul class="clearfix">
                            <li>
                                <div class="thumb">
                                    Product
                                </div>
                                <div class="price-block">
                                    Price
                                </div>
                                <div class="product-number">
                                    Quantity
                                </div>
                                <div class="total-block">
                                    Total
                                </div>
                                <div class="remove">
                                </div>
                            </li>
                            @if(Cart::count() > 0)
                            @foreach ( Cart::content() as $cart)
                            <li class="item-cart-{{ $cart->rowId }}">
                                <div class="thumb">
                                    <a class="img" href="{{ route('fe.product.product.detail',$cart->options->slug) }}">
                                        <img src="{{ $cart->options->avatar }}" alt="{{ $cart->name }}"
                                            class="img-fluid">
                                    </a>
                                    <div class="desc">
                                        <a href="{{ route('fe.product.product.detail',$cart->options->slug) }}">
                                            <h2 class="title">
                                                {{
                                                $cart->name }}
                                            </h2>
                                        </a>
                                    </div>
                                </div>
                                <div class="price-block">
                                    @if(isset($cart->option->price_old) &&$cart->option->price_old > 0)
                                    <span class="old-price">{{ number_format($cart->option->price_old) }}$</span>
                                    @endif
                                    <span class="price"> {{ number_format($cart->price) }}$</span>
                                </div>
                                <div class="product-number">
                                    <button type="button" class="btn func-minus"
                                        data-row-id="{{ $cart->rowId }}">-</button>
                                    <input type="number" value="{{ $cart->qty }}" data-row-id="{{ $cart->rowId }}"
                                        class="num-frm box-number-{{ $cart->rowId }}">
                                    <button type="button" class="btn func-plus"
                                        data-row-id="{{ $cart->rowId }}">+</button>
                                </div>
                                <div class="total-block">
                                    <span class="price">{{ number_format($cart->price *$cart->qty) }}</span><span>$</span>
                                </div>
                                <div class="remove">
                                    <a href="javascript:void(0);" class="func-remove btn-delete-item-cart"
                                        data-row-id="{{ $cart->rowId }}"><img class="pointer"
                                            src="{{ Theme::url('images/icons/icon-remove.png') }}" alt=""></a>
                                </div>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="box-info-cart">
                    <h3>Your Order</h3>
                    <div class="box-info sub-total">
                        <div>Subtotal</div>
                        <div class="price"><span>{{ $subtotal }}</span>$</div>
                    </div>
                    <div class="box-info">
                        <div>Use PLC
                            Joint Probiocare Loyalty to get your Credit</div>
                        <div>{{ $plc }}$</div>
                    </div>
                    <hr>
                    <div class="box-info total-payment">
                        <div>Total Payment</div>
                        <div class="price"><span>{{ $total }}</span>$</div>
                    </div>
                    <div class="action">
                        <a class="btn btn-success" href="{{ route('fe.shoppingcart.getCheckout') }}">
                            Check Out
                        </a>
                        <a href="#">Continue shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@stop