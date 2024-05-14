@extends('layouts.master')
@section('title')
{{__('auth.login-title')}} | @parent
@stop
@section('content')
<div class="login auth">
    <div class="auth-body">
        <div class="card-auth" style="max-width: 630px">
            <h1 class="mb-3">{{ __('auth.welcomeback') }}</h1>
            <p class="description mb-4">{{__('auth.no-account')}} <a style="color: #ffc700" href="{{ route('fe.customer.customer.register') }}">{{__('auth.sign-up')}}</a></p>
            <form-signin :link-forgot="'{{ route('fe.customer.customer.forgot') }}'"></form-signin>
        </div>
        @include('partials.login-socials')
    </div>
</div>
@stop