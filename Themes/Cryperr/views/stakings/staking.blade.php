@extends('layouts.private')

@section('title')
Staking | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')
<div class="staking-detail py-4 py-md-5">
    <div class="container-custom">
        <div class="staking-body">
            <div class="d-flex justify-content-between mb-4">
                <a class="backlink " href="/staking">
                    <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                    <div class="label">Staking Detail</div>
                </a>
            </div>
            <form-staking :package-id="{{ $package->id }}" :balance="{{$wallet->balance ?? 0}}" :term-selected-id="{{ $term }}"></form-staking>
        </div>
    </div>
</div>
@stop