@extends('layouts.master')
@section('title')
Login | @parent
@stop
@section('content')
<div class="login auth">
    <div class="auth-body">
        <div class="card-auth" style="max-width: 630px">
            <h1 class="mb-3">Welcome Back !</h1>
            <p class="description mb-4">I don’t have an account ? <a style="color: #ffc700" href="{{ route('fe.customer.customer.register') }}">Sign up</a></p>
            <form-signin :link-forgot="'{{ route('fe.customer.customer.forgot') }}'"></form-signin>
        </div>
        @include('partials.login-socials')
    </div>
</div>
@stop