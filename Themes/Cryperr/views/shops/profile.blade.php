@php
$customer = auth()
->guard('customer')
->user();
$shop = $customer->shop;
// dd($shop);
@endphp
@extends('layouts.private')

@section('title')
{{__('shop.shop-register-title')}} | @parent
@stop
@section('content')
    <div style="margin-top: 50px; margin-left: 10px;">
    @if ($shop == null)
        <h3>Chưa đăng ký cửa hàng</h3>
        <button class="btn btn-success">
            <a href="{{ route('fe.shop.shop.create') }}" style="color: white;">Đăng ký ngay</a>
        </button>
    @else
        <button class="btn btn-success">
            <a href="{{ route('fe.shop.shop.create-product') }}" style="color: white;">Create Product</a>
        </button>
    @endif
    </div>
@stop