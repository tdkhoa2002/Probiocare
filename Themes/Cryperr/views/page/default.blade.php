@extends('layouts.master')

@section('title')
{{ $page->title }} | @parent
@stop
@section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop

@section('content')
<div class="blog-detail container-custom py-4">
    <div class="d-flex justify-content-between mb-4">
        <a class="backlink " href="/">
            <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
            <div class="label">Home</div>
        </a>
    </div>
    <div class="row g-2 g-md-3 g-lg-4">
        <div class="col-md-12">
            <div class="secondary-card">
                <h2 class="title mb-2">{{ $page->title }}</h2>
                <div class="d-flex align-items-center mb-3">
                    <span class="fw-light fs-7 me-2">{{ $page->created_at }}</span>
                </div>

                <div class="blog-content">
                    {!! $page->body !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop