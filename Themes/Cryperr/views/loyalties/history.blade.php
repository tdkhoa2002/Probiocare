@extends('layouts.private')

@section('title')
My Package | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')
<div class="back">
    <a href="{{ route('fe.loyalty.loyalty.list-packages') }}">
        <img src="{{ Theme::url('images/arrow-left.png') }}">
        <div class="label">History</div>
    </a>
</div>
<div>
    <my-history></my-history>
</div>
@stop