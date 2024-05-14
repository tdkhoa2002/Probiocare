@extends('layouts.master')

@section('title')
{{ __('shopping.order_status') }} | @parent
@stop

@section('content')
<main>
    <div class="blog-detail container-custom">
        <div class="d-flex justify-content-between my-3">
            <a class="backlink " href="{{ route('fe.product.product.list') }}">
                <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                <div class="label">{{ __('shopping.order_status') }}</div>
            </a>
        </div>
    </div>
    <section class="box-carts container-custom">
        <div class="row">
            <div class="col-12">
                <div class="box-order-status">
                    <div class="title">
                        <h3>{{ __('shopping.success') }}</h3>
                        <p>{{ __('shopping.noti') }}</p>
                    </div>
                    <div class="image">
                        <img src="{{ Theme::url('images/carbon_task-complete.png') }}" alt="" />
                    </div>
                    <div class="action">
                        <a href="#" class="btn">{{ __('shopping.view') }}</a>
                        <a href="/products" class="btn btn-success">{{ __('shopping.continue_shopping') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@stop