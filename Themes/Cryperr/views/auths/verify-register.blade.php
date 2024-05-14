@extends('layouts.master')
@section('content')
<div class="login auth">
    <div class="auth-body">
        <div class="card-auth" style="max-width: 630px">
            <h1 class="mb-3">Verification Code</h1>
            <form class="row" method="post" action="{{ route('fe.customer.customer.handleVerifyRegister') }}">
                @csrf
                <div class="col-12 mb-3">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="number" class="form-control input" id="code" aria-describedby="emailHelp" name="code"
                        placeholder="Enter your verify code" value="{{ request()->get('code') }}" />
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
                    <a type="submit" class="btn btn-outline me-3" style="min-width: 130px"
                        href="{{route('fe.customer.customer.register')}}">Back</a>
                    <button type="submit" class="btn btn-primary ms-3" style="min-width: 130px">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
       
    var intervalId = null;
    $('#past-from-clipboard').click(async function () {
        const text = await navigator.clipboard.readText();
        $("input[name='code']").val(text);
    });
    function resendCode() {
        $('#resendVerrifyCode').click(async function () {
            const email = $("input[name='email']").val()
            $.ajax({
                method: "GET",
                url: "{{ route('fe.customer.customer.resendVerifyRegister') }}?email="+email,
                beforeSend: function (xhr) {
                    $('body').addClass('loading');
                }
            })
            .done(function (response) {
                $('body').removeClass('loading');
                if (response.error == true) {
                toastr.error(response.message)
                } else {
                toastr.success(response.message)
                $('#form-countdown').html('Resend in <span id="resend-countdown">60</span>s');
                intervalId = setInterval(countdown, 1000); 
                }
            });
        });
    }

    function countdown() {
        let start = $('#resend-countdown').text();
        if (start > 0) {
            $('#resend-countdown').text(start - 1);
            return false;
        } else {
            let html = '<a href="javascript:void(0)" id="resendVerrifyCode">Resend</a>'
            $('#form-countdown').html(html);
            clearInterval(intervalId);
            resendCode()
        }
    }
    intervalId = setInterval(countdown, 1000); 
    });
</script>
@stop