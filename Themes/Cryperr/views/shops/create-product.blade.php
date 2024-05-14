@php
$customer = auth()
->guard('customer')
->user();
$shop = $customer->shop;
foreach ($categories as $category) {
    dd($category->translatedAttributes)->title;
}
@endphp
@extends('layouts.private')

@section('title')
{{__('shop.shop-register-title')}} | @parent
@stop
@section('content')
<div class="profile py-4 py-md-5">
    <div class="px-3 px-md-4">
        <form class="form-profile row" method="POST" action="{{ route('fe.shop.shop.store-product') }}">
            @csrf
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="image" class="form-label">Image</label>
                    <div class="input-group">
                        <input name="image" type="file" class="input secondary" placeholder="Image product">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="name" class="form-label">Name</label>
                    <div class="input-group">
                        <input name="name" type="text" class="input secondary" placeholder="Name">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="code" class="form-label">Code</label>
                    <div class="input-group">
                        <input name="code" type="text" class="input secondary" placeholder="Code">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="email" class="form-label">Price</label>
                    <div class="input-group">
                        <input name="price" type="text" class="input secondary" placeholder="Price">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="email" class="form-label">Price sale</label>
                    <div class="input-group">
                        <input name="price-sale" type="text" class="input secondary" placeholder="Price sale">
                    </div>
                </div>
            </div>
            <div>
                <div class="form-item">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="input secondary" placeholder="Description" rows="4" cols="50"></textarea>
                </div>
            </div>
            {{-- <div class="col-12 col-md-6">
                <a href="{{route('api.shop.shop.register')}}" style="color: white;" class="btn btn-success">Register</a>
            </div> --}}
            <button class="btn btn-success" type="submit">
                Register Product
            </button>
        </form>
    </div>
</div>
@stop