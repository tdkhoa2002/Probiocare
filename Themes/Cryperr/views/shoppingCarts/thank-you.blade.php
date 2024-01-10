@extends('layouts.master')

@section('title')
Order Status | @parent
@stop

@section('content')
<main>
    <div class="blog-detail container-custom">
        <div class="d-flex justify-content-between my-3">
            <a class="backlink " href="{{ route('homepage') }}">
                <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                <div class="label">Order Status</div>
            </a>
        </div>
    </div>
    <section class="box-carts container-custom">
        <div class="row">
            <div class="col-12">
                <div class="box-order-status">
                    <div class="title">
                        <h3>Order Successfully</h3>
                        <p>Your order has been completed, please check your balance</p>
                    </div>
                    <div class="image">
                        <img src="{{ Theme::url('images/carbon_task-complete.png') }}" alt="" />
                    </div>
                    <div class="action">
                        <a href="#" class="btn">View Order</a>
                        <a href="#" class="btn btn-success">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@stop