@extends('layouts.master')

@section('title')
    Forgot Password | @parent
@stop
@section('content')
    <div class="login auth">
        <div class="auth-body">
            <div class="card-auth" style="max-width: 630px">
                <h1 class="mb-3">Forgot Password</h1>  
                <form class="row" method="post" action="{{ route('fe.customer.customer.forgotPassword') }}">
                    @csrf
                    <div class="col-12 mb-3">
                        <label for="email" class="form-label">Enter your email address</label>
                        <input type="email" class="form-control input" id="email" aria-describedby="emailHelp" placeholder="Enter your email address" name="email" />
                        @if($errors->has('email'))
                        <div id="emailHelp" class="form-text error">{{ $errors->first('email') }}</div>
                        @endif
                    </div>
                    <div class="action mt-3 d-flex justify-content-center">
                        <a class="btn btn-outline me-3" style="min-width: 130px" href="{{ route('fe.customer.customer.login') }}">Back</a>
                        <button type="submit" class="btn btn-primary ms-3" style="min-width: 130px">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
