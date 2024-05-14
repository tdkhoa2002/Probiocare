@extends('layouts.master')

@section('title')
{{ $page->title }} | @parent
@stop

@section('meta')
<meta name="title" content="{{ $page->meta_title}}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop

@php
// dd($dynamicfields);
// @inject('fileService', 'Modules\Media\Repositories\FileRepository');

// $file = app(Modules\Media\Repositories\FileRepository::class)->find($dynamicfields['home_01_image'])->path;
// dd($file);
@endphp

@section('content')
<main>
    <section class="">
        <div class="container-custom" style="padding: 0px!important">
            <div class="row">
                <div class="col-12">
                    <div class="right">
                        @isset($dynamicfields['home_01_image'])
                        <img
                            src="{{ app(Modules\Media\Repositories\FileRepository::class)->find($dynamicfields['home_01_image'])->path}}" />
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="" style="background: #eef2f6;">
        <div class="container-custom" style="padding: 0px!important">
            <div class="row">
                <div class="col-12">
                    <div class="right">
                        @isset($dynamicfields['home_02_image'])
                        <img
                            src="{{ app(Modules\Media\Repositories\FileRepository::class)->find($dynamicfields['home_02_image'])->path}}" />
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-3">
        <div class="container-custom">
            <div class="row">
                <div class="col-12 col-lg-5">
                    <div class="right">
                        @isset($dynamicfields['home_03_image'])
                        <img
                            src="{{ app(Modules\Media\Repositories\FileRepository::class)->find($dynamicfields['home_03_image'])->path}}" />
                        @endisset
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="left">
                        @isset($dynamicfields['home_03_title'])
                        <h2 class="title home-title">{!!$dynamicfields['home_03_title']!!}</h2>
                        @endisset
                        @isset($dynamicfields['home_03_desc'])
                        <p class=" home-desc">{!!$dynamicfields['home_03_desc']!!}</p>
                        @endisset
                        <a class="btn btn-primary" style="width: 200px"
                            href="/san-pham">
                            {{ __('home.buy_now_btn') }}</a><!--Purchase now-->
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="section-7">
        <div class="container-custom">
            <div class="row g-2 g-lg-5 justify-content-md-center">
                <div class="col-12 col-md-8">
                    <div class="right">
                        @isset($dynamicfields['home_04_faq'])
                        @foreach ($dynamicfields['home_04_faq'] as $key=> $item)
                        <div class="collapse-custom mb-4">
                            <div class="collapse-head">
                                <a data-bs-toggle="collapse" href="#collapse{{$key}}" role="button"
                                    aria-expanded="false" aria-controls="collapse{{$key}}">{!!$item['title']!!}</a>
                            </div>
                            <div class="collapse-content collapse multi-collapse" id="collapse{{$key}}">
                                <p>{!!$item['description']!!}</p>
                            </div>
                        </div>
                        @endforeach
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-custom">
            <div class="row g-2 g-md-3 g-lg-4 mb-4">
                {{-- <h2 class="title home-title">Các bài đăng gần đây</h2> <!--Recent Post--> --}}
                <h2 class="title home-title">{{ __('home.recent_posts') }}</h2>
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
        </div>
    </section>
    @if (!auth()->guard('customer')->check())
    <section class="section-8">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    {{-- <div class="subfooter">
                        <div class="title home-title">Trở thành Thành viên để đạt được nhiều quyền lợi hơn!</div>
                        <!--Become our Member to get more benefits!-->
                        <a class="btn btn-primary btn-sign-with-email"
                            href="{{route('fe.customer.customer.register')}}">
                            <!--Sign Up with Email-->
                            Đăng ký bằng Email</a>
                    </div>
                    --}}
                    <div class="subfooter">
                        <div class="title home-title">{{ __('home.become_member') }}</div>
                        <a class="btn btn-primary btn-sign-with-email" href="{{ route('fe.customer.customer.register') }}">
                            {{ __('home.sign_up_with_email') }}
                        </a>
                    </div>                    
                </div>
            </div>
        </div>
    </section>
    @endif
</main>
@stop