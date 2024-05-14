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
        <a class="backlink " href="/blogs">
            <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
            <div class="label">{{ __('blog.title') }}</div>
        </a>
    </div>
    <div class="row g-2 g-md-3 g-lg-4">
        <div class="col-md-8">
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
        <div class="col-md-4">
            <div class="secondary-card">
                <div class="d-flex align-items-center mb-3">
                    <div class="fs-5 me-3">{{ __('blog.related') }}</div>
                    <img width="24px" height="24px" src="{{ Theme::url('images/icons/history.png') }}" alt="">
                </div>
                @php
                $relatedBlogs = getRelatePost($page->id);
                @endphp
                @foreach ( $relatedBlogs as $relatedBlog)
                @php
                $image = $relatedBlog->getImageAttribute();
                $urlImage =Theme::url('images/top-banner.png');
                if($image != ""){
                $urlImage = $image->path_string;
                }
                @endphp
                <a href="{{ route('page', $relatedBlog->slug) }}" title="{{  $relatedBlog->title }}">
                    <div class="blog-item border-bottom mb-4 pb-3">
                        <div class="mb-2">
                            {{-- <img width="100%" src="{{ $urlImage }}" alt=" {{  $relatedBlog->title }}"> --}}
                            <img width="100%" data-src="{{ $urlImage }}" alt="{{ $relatedBlog->title }}" class="lazyload" loading="lazy"> 
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <div class="fs-6">{{ $relatedBlog->title }}</div>
                        </div>

                        <p class="fw-light fs-7 mb-2">
                            {{ $relatedBlog->sumary }}
                        </p>

                        <div class="fs-7 fw-light">{{ $relatedBlog->created_at }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Include lazysizes library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" integrity="sha256-LZ3B+1Ba9IWD6iMclVr8XdO9Nl9x9vnplVt57It+j9g=" crossorigin="anonymous"></script>
@stop
