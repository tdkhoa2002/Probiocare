@extends('layouts.master')

@section('title')
{{ $page->title }} | @parent
@stop

@section('meta')
<meta name="title" content="{{ $page->meta_title}}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop
@section('content')
<main>
    <div class="blog-detail container-custom">
        <div class="d-flex justify-content-between my-3">
            <a class="backlink " href="{{ route('fe.product.product.list') }}">
                <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                <div class="label">{{ $page->title }}</div>
            </a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="">
                    <div class="form-item mb-2" style="max-width: 400px">
                        <div class="input-group" style="width">
                            <div class="input-prefix pe-2">
                                <img width="18px" height="18px" src="{{ Theme::url('images/icons/search.png') }}"
                                    alt="">
                            </div>
                            <input type="text" class="input secondary" placeholder="Search Pots">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row box-products">
            @php
            $products = getAllProducts();
            $authCheck = auth()->guard('customer')->check();
            @endphp
            @foreach ($products as $product)
            @php
            $image = $product->getAvatar();
            $urlImage =Theme::url('images/top-banner.png');
            if($image != ""){
            $urlImage = $image->path_string;
            }
            @endphp
            <div class="col-md-6 mb-2 item-product">
                <a href="{{ route('fe.product.product.detail',$product->slug) }}" title="{{ $product->title }}">
                    <div class="blog-card card mb-0">
                        <img src="{{  $urlImage}}" class="card-img-top" alt="{{ $product->title }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">{{ $product->title }}</h3>
                            </div>
                            <div class="box-price">
                                @include('shoppingCarts.partials.price',[
                                'price_sale'=>$product->price_sale,
                                'price'=>$product->price,
                                'price_member'=> $authCheck ?$product->price_member:0
                                ])
                            </div>
                            <p class="sumary">{{ $product->sumary }}</p>
                            <div class="box-action">
                                <p><strong>{{ $product->total_sold }} {{ __('products.pro_sold') }}</strong></p>
                                <p>
                                    <a href="javascript:void(0);" class="btn-add-to-cart-quick"
                                        data-product-id="{{ $product->id }}"><img
                                            src="{{ Theme::url('images/icons/icon-shop.png') }}" alt=""></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        {!! $products->links('partials.pagination') !!}
    </div>
</main>
@stop