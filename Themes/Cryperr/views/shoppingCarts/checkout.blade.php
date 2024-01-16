@extends('layouts.master')

@section('title')
{{ __('shopping.title_checkout') }} | @parent
@stop

@section('content')
<main>
    <div class="blog-detail container-custom">
        <div class="d-flex justify-content-between my-3">
            <a class="backlink " href="{{ route('homepage') }}">
                <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                <div class="label">{{ __('shopping.checkout_label') }}</div>
            </a>
        </div>
    </div>
    <form action="{{ route('fe.shoppingcart.checkout') }}" method="POST" id="form_checkout">
        <section class="box-carts container-custom">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="box-table-cart mb-4">
                        <div class="table-title">
                            <span>{{ __('shopping.payment_method') }}</span>
                        </div>
                        <div class="box-form">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_method1"
                                    value="1" checked>
                                <label class="form-check-label" for="payment_method1"> <img class="pointer"
                                        src="{{ Theme::url('images/icons/icon-cod.png') }}"
                                        alt=""><span>COD</span></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_method2"
                                    value="2">
                                <label class="form-check-label" for="payment_method2"><img class="pointer"
                                        src="{{ Theme::url('images/icons/icon-bank.png') }}" alt=""><span>
                                            {{ __('shopping.bank_transfer') }}    
                                        </span></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_method3"
                                    value="3">
                                <label class="form-check-label" for="payment_method3"> <img class="pointer"
                                        src="{{ Theme::url('images/icons/icon-visa.png') }}"
                                        alt=""><span>Visa</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="box-table-cart mb-4">
                        <div class="table-title">
                            <img class="pointer" src="{{ Theme::url('images/icons/icon-delivery.png') }}" alt="">
                            <span>{{ __('shopping.delivery_option') }}</span>
                        </div>
                        <div class="box-form">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="delivery" id="delivery1"
                                    value="1" checked>
                                <label class="form-check-label" for="delivery1"><span>{{ __('shopping.standard_delivery') }}</span></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="delivery" id="delivery2"
                                    value="2">
                                <label class="form-check-label" for="delivery2"><span>{{ __('shopping.vip_delivery') }}</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="box-table-cart mb-4">
                        <div class="table-title">
                            <img class="pointer" src="{{ Theme::url('images/icons/icon-shipping.png') }}" alt="">
                            <span>{{ __('shopping.delivery_address') }}</span>
                        </div>
                        <div class="box-form">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">{{ __('shopping.fname') }}</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required
                                    placeholder="{{ __('shopping.fname_pholder') }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">{{ __('shopping.phone_num') }}</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" required
                                    placeholder="{{ __('shopping.phone_num_pholder') }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                    name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">{{ __('shopping.address') }}</label>
                                <textarea class="form-control" id="address" rows="3" name="address" required></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="box-info-cart">
                        <h3>{{ __('shopping.your_order') }}</h3>
                        <div class="box-info sub-total">
                            <div>{{ __('shopping.subtotal') }}</div>
                            <div class="price"><span>{{ $subtotal }}</span>đ</div>
                        </div>
                        <div class="box-info">
                            <div>{{ __('shopping.pay_plc') }}</div>
                            <div>{{ $plc }}đ</div>
                        </div>
                        <hr>
                        <div class="box-info total-payment">
                            <div>{{ __('shopping.total_payment') }}</div>
                            <div class="price"><span>{{ $total }}</span>đ</div>
                        </div>
                        <div class="action">
                            <button type="submit" class="btn btn-success">
                                {{ __('shopping.checkout_btn') }}
                            </button>
                            <a href="#">{{ __('shopping.continue_shopping') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
@stop