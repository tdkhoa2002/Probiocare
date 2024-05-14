@php
    // $customer = auth()->guard('customer')->user();
    // $wallets = $customer->wallets;
    // $curren
    // dd($countries);
@endphp
@extends('layouts.private')

@section('title')
{{__('shop.shop-register-title')}} | @parent
@stop
@section('content')
<div class="profile py-4 py-md-5">
    <div class="px-3 px-md-4">
        <form class="form-profile row" method="POST" action="{{ route('fe.shop.shop.register') }}">
            @csrf
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
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <input name="email" type="text" class="input secondary" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="coutry" class="form-label">Country</label>
                    <select name="country_id" id="country" class="input secondary">
                        @foreach ($countries as $country)
                        <option value="{{$country->id}}" 
                            {{-- {{ $country->id === $customer->profile->country_id ?'selected':'' }} --}}
                            >{{$country->country_name}}</option>
                        @endforeach
                    </select>
                    {{-- <div class="form-text">Error</div> --}}
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="address" class="form-label">Address</label>
                    <div class="input-group">
                        <input name="address" type="text" class="input secondary" placeholder="Address">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="phoneNumber" class="form-label">Phone Number</label>
                    <div class="input-group">
                        <input name="phoneNumber" type="text" class="input secondary" placeholder="Phone">
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
                Register
            </button>
        </form>
    </div>
</div>
@stop