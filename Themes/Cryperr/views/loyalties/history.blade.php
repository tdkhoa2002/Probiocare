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
    <img src="{{ Theme::url('images/arrow-left.png') }}">
    <a href="{{ route('fe.loyalty.loyalty.list-packages') }}"> History </a>
</div>
<div>
    <my-history></my-history>
</div>
@stop