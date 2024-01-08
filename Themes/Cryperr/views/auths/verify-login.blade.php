@extends('layouts.master')

@section('title')
Verify Login| @parent
@stop
@section('content')
<div class="login auth">
    <div class="auth-body">
        <div class="card-auth" style="max-width: 630px">
            <h1 class="mb-3">Verification Code</h1>
            <form class="row" method="post" action="{{ route('fe.customer.customer.hanldeLogin') }}">
                @csrf
                <input type="hidden" name="isEmail" value="{{ $isEmail }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="col-12 mb-3">
                    <input type="number" class="form-control input" name="code" id="number" aria-describedby="emailHelp"
                        placeholder="Enter your code" />
                    @if($errors->has('code'))
                    <div class="form-text">{{ $errors->first('code') }}</div>
                    @endif
                </div>

                <div class="d-flex justify-content-between w-100">
                    <div class="mb-3 form-countdown" id="form-countdown">
                        Resend in <span id="resend-countdown">60</span>s
                    </div>
                    <a class="form-link" id="past-from-clipboard">Paste</a>
                </div>

                <div class="action mt-3 d-flex justify-content-center">
                    <a href="{{ route('fe.customer.customer.login') }}" class="btn btn-outline me-3" style="min-width: 130px">Back</a>
                    <button type="submit" class="btn btn-primary ms-3" style="min-width: 130px">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#past-from-clipboard').click(async function () {
            const text = await navigator.clipboard.readText();
            $("input[name='code']").val(text);
        } );
        function countdown(){
            let start = $('#resend-countdown').text();
            if(start>0){
                $('#resend-countdown').text(start-1);
            }else{
                let html = '<a >Request again!</a>'
                $('#form-countdown').html(html);
            }
            // return t;
        }
        setInterval(countdown, 1000);

    })
</script>
@stop