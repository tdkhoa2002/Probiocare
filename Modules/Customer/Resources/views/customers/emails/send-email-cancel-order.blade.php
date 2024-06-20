@extends('layouts.email-master')

@php
$customer_name = $customer->profile->firstname;
$customer_id = $customer->id;
@endphp

@section('title')
Your order cancelled
@stop
@section('customerID')
{{$customer_id}}
@stop

@section('content')
<p>
    <strong>Hi {{$customer_name }}!</strong>
</p>
<p>
    We regret to inform you that your order with the ID <strong>102</strong> has been cancelled.<br><br>

    As a gesture of goodwill, we have issued you a discount coupon worth 20 PCT tokens. You can use this coupon on your next purchase.<br><br>

    If you have any questions or concerns, please do not hesitate to contact our support team.<br>

    Thank you for your understanding.<br><br>
    
    Best regards,<br>
    Probiocate
</p>
@stop