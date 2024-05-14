@extends('layouts.email-master')

@php
$customer_name = $customer->profile->firstname;
$customer_id = $customer->id;
$link = route('fe.customer.customer.verifyRegister').'?token='.$code;
@endphp

@section('title')
Verify Your Email!
@stop
@section('customerID')
{{$customer_id}}
@stop

@section('content')
<p>
    <strong>Hi {{$customer_name }}!</strong>
</p>
<p>
    <strong>{{$code}}</strong><br>
    is your verification code!<br><br>

    The verification code will be valid for 30 minutes. Please do not share this code with anyone.<br>

    Or copy the link below:<br>

    {{$link}}
</p>
@stop