@extends('layouts.master')

@section('title')
{{ $page->title }} | @parent
@stop
@section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop

@section('content')
<div class="blogs container-custom py-4">
    <div class="row g-2 g-md-3 g-lg-4">
        {{-- <div class="col-12">
            <form action="">
                <div class="form-item mb-2" style="max-width: 400px">
                    <div class="input-group" style="width">
                        <div class="input-prefix pe-2">
                            <img width="18px" height="18px" src="{{ Theme::url('images/icons/search.png') }}" alt="">
                        </div>
                        <input type="text" class="input secondary" placeholder="Search Pots">
                    </div>
                </div>
            </form>
        </div> --}}
        @php
        $blogs = getAllBlogs();
        @endphp
        @foreach ($blogs as $blog)
        @php
            $image = $blog->getImageAttribute();
            $urlImage =Theme::url('images/top-banner.png');
            if($image != ""){
                $urlImage = $image->path_string;
            }
        @endphp
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('page',$blog->slug) }}" title="{{ $blog->title }}">
                <div class="blog-card card mb-0">
                    <img src="{{  $urlImage}}" class="card-img-top" alt="{{ $blog->title }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title mb-2 mb-md-3">{{ $blog->title }}</h5>
                        </div>
                        <p class="card-des fw-light mb-2 mb-md-3">{{ $blog->sumary }}</p>
                        <div class="fw-light fs-8 fs-md-6">{{ $blog->created_at }}</div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    {!! $blogs->links('partials.pagination') !!}
</div>
@stop