@extends('layouts.master')

@section('title')
{{ __('shopping.title_cart') }} | @parent
@stop

@section('content')
<main>
    <div class="blog-detail container-custom">
        <div class="d-flex justify-content-between my-3">
            <a class="backlink " href="{{ route('fe.product.product.list') }}">
                <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                <div class="label">{{ __('shopping.cart_label') }}</div>
            </a>
        </div>
    </div>
    <section class="box-carts container-custom">
        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="box-table-cart">
                    <div class="table-title">
                        <img class="pointer" src="{{ Theme::url('images/icons/icon-shop.png') }}" alt="">
                        <span>{{ __('shopping.order_summary') }}</span>
                    </div>
                    <div class="box-table">
                        <ul class="clearfix">
                            <li>
                                <div class="thumb">
                                    {{ __('shopping.product') }}
                                </div>
                                <div class="price-block">
                                    {{ __('shopping.price') }}
                                </div>
                                <div class="product-number">
                                    {{ __('shopping.quantity') }}
                                </div>
                                <div class="total-block">
                                    {{ __('shopping.total') }}
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
                                    @include('shoppingCarts.partials.price',['price_sale'=>$cart->options->price_old??0,'price'=>$cart->price])
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
                                    <span class="price">{{ number_format($cart->price *$cart->qty)
                                        }}</span><span>$</span>
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
                        <a class="btn btn-success" href="{{ route('fe.shoppingcart.getCheckout') }}">
                            {{ __('shopping.checkout_btn') }}
                        </a>
                        <a href="/products">{{ __('shopping.continue_shopping') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@stop