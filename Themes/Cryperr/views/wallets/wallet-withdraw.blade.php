@extends('layouts.private')

@section('title')
    Withdraw | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')
    <div class="withdraw ">
        <div class="d-flex justify-content-between mb-4">
            <a class="backlink " href="/wallet">
                <div class="d-flex align-items-center">
                    <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                    <div class="label">Withdraw</div>
                </div>
            </a>
        </div>
        <withdraw :currency_id="{{ $currencyIdSelected }}"></withdraw>
    </div>
@stop
