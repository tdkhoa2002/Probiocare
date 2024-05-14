@extends('layouts.master')

@section('title')
{{__('auth.register-title')}} | @parent
@stop
@section('content')
<div class="signup auth">
    <div class="auth-body">
        <div class="card-auth" style="max-width: 1070px">
            <h1 class="mb-3">{{__('auth.register-header')}}</h1>
            <form class="row" method="post" action="{{ route('fe.customer.customer.postRegister') }}">
                @csrf
                <div class="col-12 col-md-6 mb-3">
                    <label for="firstname" class="form-label">{{__('auth.firstname')}}</label>
                    <input class="form-control input" id="firstname" aria-describedby="emailHelp"
                        placeholder="{{__('auth.p-firstname')}}" name="firstname" value="{{ old('firstname') }}" />
                    @if ($errors->has('firstname'))
                    <div class="form-text error">{{ $errors->first('firstname') }}</div>
                    @endif
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="lastname" class="form-label">{{__('auth.lastname')}}</label>
                    <input class="form-control input" id="lastname" value="{{ old('lastname') }}"
                        placeholder="{{__('auth.p-lastname')}}" name="lastname" />
                    @if ($errors->has('firstname'))
                    <div class="form-text error">{{ $errors->first('lastname') }}</div>
                    @endif
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control input" id="email" value="{{ old('email') }}"
                        placeholder="{{__('auth.p-email')}}" name="email" />
                    @if ($errors->has('email'))
                    <div class="form-text error">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="country" class="form-label">{{__('auth.country')}}</label>
                    @php
                    $countries = \Modules\Customer\Entities\Country::all();
                    @endphp
                    <select class="input secondary" id="country" name="country_id" data-theme="default">
                        <option value="">{{__('auth.p-country')}}</option>
                        @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('country_id'))
                    <div class="form-text error">{{ $errors->first('country_id') }}</div>
                    @endif
                </div>
                <div class="col-12 col-md-6  mb-3">
                    <label for="password" class="form-label">{{__('auth.password')}}</label>
                    <div class="input-group-password">
                        <input type="password" class="form-control input" id="password" placeholder="{{__('auth.p-password')}}"
                            name="password" />
                        <span class="togglePassword" id="">
                            <img src="{{ Theme::url('/images/eye-lock.png') }}" alt="" />
                        </span>
                    </div>
                    @if ($errors->has('password'))
                    <div class="form-text error">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="col-12 col-md-6  mb-3">
                    <label for="confirmp-password" class="form-label">{{__('auth.confirm-password')}}</label>
                    <div class="input-group-password">
                        <input type="password" class="form-control input" id="password_confirmation"
                            placeholder="{{__('auth.p-confirm-password')}}" name="password_confirmation" />
                        <span class="togglePassword" id="">
                            <img src="{{ Theme::url('/images/eye-lock.png') }}" alt="" />
                        </span>
                    </div>
                    @if ($errors->has('password_confirmation'))
                    <div class="form-text error">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="ref_code" class="form-label">{{__('auth.ref-code')}}</label>
                    <input type="text" class="form-control input" id="ref_code" value="{{ $ref_code }}"
                        placeholder="{{__('auth.p-ref-code')}}" name="ref_code" />
                    @if ($errors->has('ref_code'))
                    <div class="form-text error">{{ $errors->first('ref_code') }}</div>
                    @endif
                </div>
                <div class="d-flex justify-content-center w-100">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="signup_agree" required />
                        <label class="form-check-label" for="remember">{{__('auth.uspp')}}</label>
                    </div>
                </div>
                <div class="action mt-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">{{__('auth.sign-up')}}</button>
                </div>

                <p class="description mt-4">{{__('auth.already-account')}} <a style="color: #ffc700"
                        href="{{ route('fe.customer.customer.login') }}">{{__('auth.sign-in')}}</a>
                </p>
            </form>
        </div>

        {{-- @include('partials.login-socials') --}}
    </div>
</div>
@stop