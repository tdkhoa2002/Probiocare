@extends('layouts.email-master')

@php
$customer_name = $customer->profile->firstname;
$customer_id = $customer->id;
$link = route('fe.customer.customer.verifyRegister').'?token='.$code;
@endphp

@section('title')
Verify Successfully!
@stop
@section('customerID')
{{$customer_id}}
@stop

@section('content')
<p>
    <strong>Hi {{$customer_name }}!</strong>
</p>
<p>
    Your account is now in full protection with us!<br>
    Enjoy and make your profit.<br>
</p>
@stop