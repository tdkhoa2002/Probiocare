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
    <section class="banner">
        <div class="container-custom">
            <div class="row g-2 g-lg-3">
                <div class="col-12 col-lg-6">
                    <div class="left">
                        @isset($dynamicfields['home_01_title'])
                        <h1>{!!$dynamicfields['home_01_title']!!}</h1>
                        @endisset
                        @isset($dynamicfields['home_01_desc'])
                        <p class="description">
                            {!!$dynamicfields['home_01_desc']!!}
                        </p>
                        @endisset
                        <a class="btn btn-primary btn-sign-with-email"
                            href="{{route('fe.customer.customer.register')}}"><img
                                src="{{ Theme::url('/images/email.png') }}" />Sign up with Email</a>
                        <a class="btn btn-outline btn-sign-with-email"
                            href="{{route('fe.customer.customer.login')}}">Sign in</a>

                    </div>
                </div>
                <div class="col-12 col-lg-6">
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

    <section class="section-1">
        <div class="total-info">
            <div class="row g-3 g-lg-5">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card-total-info">
                        <h4>Registered Users</h4>
                        <p>{{themeOption(setting('core::template', null, '').'::registered_user')}}</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card-total-info">
                        <h4>Lowest Transaction Fee</h4>
                        <p>{{themeOption(setting('core::template', null, '').'::transaction_fee')}}</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card-total-info">
                        <h4>Cryptocurrencies</h4>
                        <p>{{themeOption(setting('core::template', null, '').'::cryptocurrencies')}}</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card-total-info">
                        <h4>Trading Pairs</h4>
                        <p>{{themeOption(setting('core::template', null, '').'::trading_pairs')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <currencies-list></currencies-list>
    <staking-list title="Earn daily rewards on your idle tokens"
        description="Simple & Secure. Search popular coins and start earning."
        stakingurl={{route('fe.staking.staking.staking-list')}}>
    </staking-list>

    <section class="section-3">
        <div class="container-custom">
            <div class="row">
                <div class="col-12 col-lg-7">
                    <div class="left">
                        @isset($dynamicfields['home_02_title'])
                        <h2 class="title home-title">{!!$dynamicfields['home_02_title']!!}</h2>
                        @endisset
                        @isset($dynamicfields['home_02_desc'])
                        <ul>
                            @foreach ($dynamicfields['home_02_desc'] as $key=> $item)
                            <li>
                                <span class="count me-2"> {{$key+1}} </span>
                                <p>{!!$item['title']!!}</p>
                            </li>
                            @endforeach

                        </ul>
                        @endisset
                    </div>
                </div>
                <div class="col-12 col-lg-5">
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

    <section class="section-6">
        <div class="container-custom">
            @isset($dynamicfields['home_03_title'])
            <h2 class="title home-title">{!!$dynamicfields['home_03_title']!!}</h2>
            @endisset
            <div class="row g-3 g-lg-4">
                @isset($dynamicfields['home_03_desc'])
                @foreach ($dynamicfields['home_03_desc'] as $key=> $item)
                <div class="col-6 col-md-6 col-lg-4">
                    <div class="item">
                        <img src="{{ app(Modules\Media\Repositories\FileRepository::class)->find($item['image'])->path}}"
                            alt="{!!$item['title']!!}" />
                        <div class="title">{!!$item['title']!!}</div>
                        <p>{!!$item['description']!!}</p>
                    </div>
                </div>
                @endforeach
                @endisset
            </div>
        </div>
    </section>

    <section class="section-7">
        <div class="container-custom">
            <div class="row g-2 g-lg-5">
                <div class="col-12 col-md-4">
                    <div class="left">
                        <img src="{{ Theme::url('/images/faq.png') }}" alt="" />
                    </div>
                </div>
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
    @if (!auth()->guard('customer')->check())
    <section class="section-8">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="subfooter">
                        <div class="title home-title">Register for free <span class="text-primary">NOW!</span></div>
                        <a class="btn btn-primary btn-sign-with-email"
                            href="{{route('fe.customer.customer.register')}}">
                            Sign up with Email</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
</main>
@stop