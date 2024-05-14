@extends('layouts.private')

@section('title')
My Account | @parent
@stop
@php
$customer = auth()
->guard('customer')
->user();
$profile = $customer->profile;
// dd($customer->status_kyc);
@endphp
@section('content')
<div class="profile py-4 py-md-5">
    <div class="px-3 px-md-4">
        <form class="form-profile row" method="post" action="{{ route('fe.customer.customer.account.updateProfile') }}">
            @csrf
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3 mb-md-4">
                <div class="wrap-user-info pe-3">
                    {{-- <img class="avatar" class="me-3" width="68px" height="68px"
                        src="{{ Theme::url('images/user-default.png') }}" alt=""> --}}
                    <div class="d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center fs-4 fw-medium">
                            <div class="d-flex align-items-center" style="max-width: 300px">
                                <input name="firstname" class="w-50 fs-5 fs-md-4 fw-medium pe-2" type="text"
                                    value="{{ $profile->firstname }}" placeholder="First name">
                                <input name="lastname" class="w-50 fs-5 fs-md-4 fw-medium pe-2" type="text"
                                    value="{{ $profile->lastname }}" placeholder="Last name">
                            </div>
                            <img class="pointer me-2" width="18px" height="18px"
                                src="{{ Theme::url('images/icons/checked-blue.png') }}" alt="">
                            <img class="pointer" width="18px" height="18px"
                                src="{{ Theme::url('images/icons/edit.png') }}" alt="">
                        </div>
                        <div class="d-flex align-items-center w-100">
                            <input name="email" class="email fs-7 fs-md-6 fw-light w-100" value={{ $customer->email }}
                            readonly >
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary d-flex align-items-center" type="submit" style="min-width: 100px">
                    <img class="me-2" width="17px" height="17px" src="{{ Theme::url('images/icons/edit.png') }}" alt="">
                    Save
                </button>
            </div>

            <div class="form-profile row">
                <div class="col-12 col-md-6">
                    <div class="form-item">
                        <label for="coutry" class="form-label">Country</label>
                        <div class="input-group">
                            <select name="country_id" class="input secondary">
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @if ($country->id === 3) sellect="sellected" @endif
                                    >
                                    {{ $country->country_name }}
                                </option>
                                @endforeach
                            </select>
                            <img width="12px" height="8px" src="{{ Theme::url('images/icons/down-outline.png') }}"
                                alt="">
                            {{-- <div class="invalid-feedback">Error</div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-item">
                        <label for="address" class="form-label">Address</label>
                        <div class="input-group">
                            <input name="address" type="text" class="input secondary" value="{{ $profile->address }}"
                                placeholder="Address">
                            <div class="ms-2">
                                <img width="18px" height="18px" src="{{ Theme::url('images/icons/edit.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-text">Error</div> --}}
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-item">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <div class="input-group">
                            {{-- <div class="text-nowrap">+84<span class="ms-2 me-2">|</span></div> --}}
                            <input name="phone_number" type="text" class="input" value="{{ $profile->phone_number }}"
                                placeholder="Phone number">
                            <div class="ms-2">
                                <img width="18px" height="18px" src="{{ Theme::url('images/icons/edit.png') }}" alt="">
                            </div>
                        </div>
                        {{-- <div class="form-text">Error</div> --}}
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-item">
                        <label for="birthday" class="form-label">Birthday</label>
                        <input name="birthday" type="date" class="input secondary" value="{{ $profile->birthday }}">
                        {{-- <div class="form-text">Error</div> --}}
                    </div>
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

        {{-- <a href="{{ route('fe.wallet.wallet.list') }}">
            <div class="box-wallet bg-secondary rounded px-4 py-3 mt-4">
                <div class="d-flex align-items-center mb-2">
                    <img class="me-2" width="24px" src="{{ Theme::url('images/icons/wallet.png') }}" alt="">
                    <div class="fs-5 fw-medium">Wallet</div>
                </div>
                <div class="account-risk d-flex align-items-center">
                    <div class="me-2">Your assets will be safety kept here and the multi-chain makes it easy to
                        use.</div>
                </div>
            </div>
        </a> --}}
    </div>
</div>
@stop