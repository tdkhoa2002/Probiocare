@extends('layouts.master')

@section('title')
    {{ $page->title }} | @parent
@stop
@section('meta')
    <meta name="title" content="{{ $page->meta_title }}" />
    <meta name="description" content="{{ $page->meta_description }}" />
@stop

@section('content')
    <div class="auth">
        <div class="auth-body">
            <div class="card-auth" style="max-width: 630px">
                <h1 class="mb-3">Contact Us</h1>
                <p class="description mb-4">We would like to hear from you !</p>
                <form class="row" method="post" action="{{ route('fe.customer.customer.postLogin') }}">
                    @csrf
                    <div class="col-12 ">
                        <div class="form-item">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control input" id="email" value="{{ old('email') }}" aria-describedby="emailHelp" name="email" />
                            <div class="invalid-feedback">error</div>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <div class="form-item">
                            <label for="password" class="form-label">Subject</label>
                            <input type="email" class="form-control input" id="email" value="{{ old('email') }}" aria-describedby="emailHelp" name="email" />
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-item">
                            <div class="form-label">Message </div>
                            <textarea class="input fs-7 py-2" style="height: 150px" name="message" id="" cols="30" rows="10">Lorem ipsum dolor sit amet consectetur. Praesent cursus sed pretium a morbi. Viverra arcu volutpat sapien dictum pellentesque quam sed est sit. Morbi quis metus quisque aliquam....</textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="light-card">
                            Recaptcha
                        </div>
                    </div>

                    <div class="action mt-4 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary" style="min-width: 150px">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
