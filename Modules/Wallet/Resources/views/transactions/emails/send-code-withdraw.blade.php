@extends('layouts.email-master')

@php
$customer_name = $customer->profile->firstname;
$amount = $transaction->amount;
$currencyCode = $transaction->currency->code;
$to = $transaction->to;
$customer_id = $customer->id;
@endphp

@section('title')
Withdraw verification!
@stop
@section('customerID')
{{$customer_id}}
@stop

@section('content')
<p>
    <strong>Hi {{$customer_name }}!</strong>
</p>
<p>
    <strong>{{$code}}</strong><br><br>
    is your verification code!<br><br>

    Transaction:<br>
    <table>
        <tbody>
            <tr>
                <td>Amount</td>
                <td>{{$amount}}</td>
            </tr>
            <tr>
                <td>Currency</td>
                <td>{{$currencyCode}}</td>
            </tr>
            <tr>
                <td>Reciever</td>
                <td>{{$to}}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>Pending Accept</td>
            </tr>
        </tbody>

    </table>
    <br>
    The verification code will be valid for 30 minutes. Please do not share this code with anyone.<br>

</p>
@stop