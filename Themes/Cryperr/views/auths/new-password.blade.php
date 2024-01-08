@extends('layouts.master')

@section('title')
New password | @parent
@stop
@section('content')
<div class="login auth">
    <div class="auth-body">
        <div class="card-auth" style="max-width: 630px">
            <h1 class="mb-3">New Password</h1>
            <form class="row" method="post" action="{{ route('fe.customer.customer.changePassword') }}">
                @csrf
                <div class="col-12 mb-3">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <label for="verify_code" class="form-label">Verify Code</label>
                    <div class="input-group-password">
                        <input type="number" class="form-control input" id="code"
                            value="{{ old('token',$token) }}" name="code" placeholder="Verify Code" />
                    </div>
                    @if($errors->has('code'))
                    <div id="verify_codeHelp" class="form-text error">{{ $errors->first('code') }}</div>
                    @endif
                </div>
                <div class="col-12 mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-group-password">
                        <input type="password" class="form-control input" id="password" name="password"
                            placeholder="New Password" />
                        <span class="togglePassword" id="">
                            <img src="{{ Theme::url('/images/eye-lock.png') }}" alt="" />
                        </span>
                    </div>
                    @if($errors->has('password'))
                    <div id="password_codeHelp" class="form-text error">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="col-12 mb-3">
                    <label for="confirmPassword" class="form-label">Confirm New Password</label>
                    <div class="input-group-password">
                        <input type="password" class="form-control input" name="password_confirmation" id="password-confirm"
                            placeholder="Confirm New Password" />
                        <span class="togglePassword" id="">
                            <img src="{{ Theme::url('/images/eye-lock.png') }}" alt="" />
                        </span>
                    </div>
                    @if($errors->has('password_confirmation'))
                    <div id="confirmPasswordHelp" class="form-text error">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>

                <div class="action mt-3 d-flex justify-content-center">
                    <a class="btn btn-outline me-3" style="min-width: 130px" href="{{ route('fe.customer.customer.login') }}">Back</a>
                    <button type="submit" class="btn btn-primary ms-3" style="min-width: 130px">Change</button>
                </div>
            </form>
        </div>

    </div>
</div>
@stop