@extends('layouts.private')

@section('title')
My Account | @parent
@stop
@php
$customer = auth()->guard('customer')->user();
$profile = $customer->profile;
@endphp
@section('content')
<div class="profile py-4 py-md-5">
    <div class="px-3 px-md-4">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 mb-md-4">
            <div class="wrap-user-info">
                <div>
                    <div class="fs-4 fw-medium">
                        <span class="name fs-5 fs-md-4 me-2">
                            {{$profile->firstname}} {{$profile->lastname}}
                        </span>
                        <img class="pointer me-2" width="18px" height="18px"
                            src="{{ Theme::url('images/icons/checked-blue.png') }}" alt="">
                    </div>
                    <span class=" email  fs-7 fs-md-6 fw-light me-2">
                        {{$customer->email}}
                    </span>
                </div>
            </div>
            <a href="{{ route('fe.customer.customer.account.edit') }}">
                <button class="btn btn-primary d-flex align-items-center">
                    <img class="me-2" width="17px" height="17px" src="{{ Theme::url('images/icons/edit.png') }}" alt="">
                    Edit
                </button>
            </a>
        </div>

        <form class="form-profile row">
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="coutry" class="form-label">Country</label>
                    <select name="country" id="country" class="input secondary" disabled>
                        @foreach ($countries as $country)
                        <option value="{{$country->id}}" {{ $country->id === $customer->profile->country_id ?'selected':'' }}>{{$country->country_name}}</option>
                        @endforeach
                    </select>
                    {{-- <div class="form-text">Error</div> --}}
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="address" class="form-label">Address</label>
                    <div class="input-group">
                        <input type="text" class="input secondary" value="{{$profile->address}}" placeholder="Address"
                            disabled>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="phoneNumber" class="form-label">Phone Number</label>
                    <div class="input-group">
                        {{-- <div class="text-nowrap">+84<span class="ms-2 me-2">|</span></div> --}}
                        <input type="text" class="input" value="{{$profile->phone_number}}" placeholder="Phone number"
                            disabled>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-item">
                    <label for="birthday" class="form-label">Birthday</label>
                    <input type="date" class="input secondary" value="{{$profile->birthday}}"
                        data-date-format="DD-MMMM-YYYY" disabled>
                </div>
            </div>
        </form>
        <change-password></change-password>
        <a href="#">
            <div class="box-security bg-secondary rounded px-4 py-3 mt-2">
                <div class="d-flex align-items-center mb-2">
                    <img class="me-2" width="24px" src="{{ Theme::url('images/icons/security.png') }}" alt="">
                    <div class="fs-5 fw-medium">Security</div>
                </div>
                <div class="account-risk d-flex align-items-center">
                    <div class="me-2 fw-">Account risk level:</div> <span class="risk"></span> <span
                        class="risk"></span>
                    <span class="risk"></span>
                </div>
            </div>
        </a>

        {{-- <a href="{{route('fe.wallet.wallet.list')}}">
            <div class="box-wallet bg-secondary rounded px-4 py-3 mt-4">
                <div class="d-flex align-items-center mb-2">
                    <img class="me-2" width="24px" src="{{ Theme::url('images/icons/wallet.png') }}" alt="">
                    <div class="fs-5 fw-medium">Wallet</div>
                </div>
                <div class="account-risk d-flex align-items-center">
                    <div class="me-2">Your assets will be safety kept here and the multi-chain makes it easy to use.
                    </div>
                </div>
            </div>
        </a> --}}
    </div>
</div>
@stop