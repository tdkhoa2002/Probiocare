@extends('layouts.master')

@section('title')
{{ $product->title }} | @parent
@stop

@section('meta')
<meta name="title" content="{{ $product->meta_title}}" />
<meta name="description" content="{{ $product->meta_description }}" />
@stop
@section('content')
@php
$image = $product->getAvatar();
$urlImage =Theme::url('images/top-banner.png');
if($image != ""){
$urlImage = $image->path_string;
}
@endphp
<main>
    <div class="blog-detail container-custom">
        <div class="d-flex justify-content-between my-3">
            <a class="backlink " href="{{ route('homepage') }}">
                <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                <div class="label">Product Detail</div>
            </a>
        </div>
    </div>
    <div class="container-custom box-product-detail">
        <div class="box-top-product-detail">
            <div class="row">
                <div class="col-lg-6">
                    <div class="box-banner">
                        <img src="{{ $urlImage }}" alt="{{ $product->title }}" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="box-title">
                        <h1>{{ $product->title }}</h1>
                        <div class="box-price">
                            Price: <strong> ${{ $product->price_sale }}</strong>
                        </div>
                        <p class="sumary">{{ $product->sumary }}</p>
                        <div class="box-action">
                            <button type="button" class="btn btn-success btn-add-to-cart-quick"
                                data-product-id="{{ $product->id }}">
                                Buy now
                            </button>
                            <button type="button" class="btn btn-add-to-cart" data-product-id="{{ $product->id }}">
                                <span>Add to cart</span>
                                <img class="pointer" src="{{ Theme::url('images/icons/icon-shop.png') }}" alt="">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-content-product-detail">
            {!! $product->product_info !!}
        </div>
    </div>
</main>
@stop