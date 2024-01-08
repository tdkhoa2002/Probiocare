@extends('layouts.master')

@section('title')
    {{ $page->title }} | @parent
@stop
@section('meta')
    <meta name="title" content="{{ $page->meta_title }}" />
    <meta name="description" content="{{ $page->meta_description }}" />
@stop
 
@section('content')
    <div class="faq py-4 py-md-5">
        <div class="container-custom">
            <h1 class="faq-title text-center mb-4">FAQ</h1>
            <div class="secondary-card">
                <div class="collapse-custom mb-3 border-bottom">
                    <div class="collapse-head mb-3 w-100">
                        <a class="d-flex justify-content-between" data-bs-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
                            <div class="text fs-6 fw-medium w-100" >Why should I use MetaViral Cex ?</div>
                            <img class="me-2" width="24px" height="24px" src="{{ Theme::url('images/icons/plus-square.png') }}" alt="" />
                        </a>
                    </div>
                    <div class="collapse-content collapse multi-collapse" id="collapse1">
                        <p class="fw-light fs-7 mb-4">MetaViral Cex is a privacy tool for crypto participants of all shapes and sizes. Public blockchains are, well, public! In other words, all of your transactions are easily traceable. Paying your friend back? Donating to a cause? Submitting payroll? Actively trading ?</p>
                        <p class="fw-light fs-7 mb-4">In all of these scenarios, the recipient could easily trace back the transaction to one wallet. In other words, people could trace back to your net worth, holdings, investments, and spending habits.</p>
                        <p class="fw-light fs-7 mb-4">You don’t walk around with a name tag of your net worth in real life, so why should crypto be any different? Check out this Medium article for more information.</p>
                    </div>
                </div>

                <div class="collapse-custom mb-3 border-bottom">
                    <div class="collapse-head mb-3 w-100">
                        <a class="d-flex justify-content-between" data-bs-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">
                            <div class="text fs-6 fw-medium w-100" >How does MetaViral Cex work ?</div>
                            <img class="me-2" width="24px" height="24px" src="{{ Theme::url('images/icons/plus-square.png') }}" alt="" />
                        </a>
                    </div>
                    <div class="collapse-content collapse multi-collapse" id="collapse2">
                        <p class="fw-light fs-7 mb-4">MetaViral Cex is a privacy tool for crypto participants of all shapes and sizes. Public blockchains are, well, public! In other words, all of your transactions are easily traceable. Paying your friend back? Donating to a cause? Submitting payroll? Actively trading ?</p>
                        <p class="fw-light fs-7 mb-4">In all of these scenarios, the recipient could easily trace back the transaction to one wallet. In other words, people could trace back to your net worth, holdings, investments, and spending habits.</p>
                        <p class="fw-light fs-7 mb-4">You don’t walk around with a name tag of your net worth in real life, so why should crypto be any different? Check out this Medium article for more information.</p>
                    </div>
                </div>

                <div class="collapse-custom mb-3 border-bottom">
                    <div class="collapse-head mb-3 w-100">
                        <a class="d-flex justify-content-between" data-bs-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">
                            <div class="text fs-6 fw-medium w-100" >What fees does MetaViral Cex charge ?</div>
                            <img class="me-2" width="24px" height="24px" src="{{ Theme::url('images/icons/plus-square.png') }}" alt="" />
                        </a>
                    </div>
                    <div class="collapse-content collapse multi-collapse" id="collapse3">
                        <p class="fw-light fs-7 mb-4">MetaViral Cex is a privacy tool for crypto participants of all shapes and sizes. Public blockchains are, well, public! In other words, all of your transactions are easily traceable. Paying your friend back? Donating to a cause? Submitting payroll? Actively trading ?</p>
                        <p class="fw-light fs-7 mb-4">In all of these scenarios, the recipient could easily trace back the transaction to one wallet. In other words, people could trace back to your net worth, holdings, investments, and spending habits.</p>
                        <p class="fw-light fs-7 mb-4">You don’t walk around with a name tag of your net worth in real life, so why should crypto be any different? Check out this Medium article for more information.</p>
                    </div>
                </div>

                <div class="collapse-custom mb-3 border-bottom">
                    <div class="collapse-head mb-3 w-100">
                        <a class="d-flex justify-content-between" data-bs-toggle="collapse" href="#collapse4" role="button" aria-expanded="false" aria-controls="collapse4">
                            <div class="text fs-6 fw-medium w-100" >How can I be sure that MetaViral Cex is safe ?</div>
                            <img class="me-2" width="24px" height="24px" src="{{ Theme::url('images/icons/plus-square.png') }}" alt="" />
                        </a>
                    </div>
                    <div class="collapse-content collapse multi-collapse" id="collapse4">
                        <p class="fw-light fs-7 mb-4">MetaViral Cex is a privacy tool for crypto participants of all shapes and sizes. Public blockchains are, well, public! In other words, all of your transactions are easily traceable. Paying your friend back? Donating to a cause? Submitting payroll? Actively trading ?</p>
                        <p class="fw-light fs-7 mb-4">In all of these scenarios, the recipient could easily trace back the transaction to one wallet. In other words, people could trace back to your net worth, holdings, investments, and spending habits.</p>
                        <p class="fw-light fs-7 mb-4">You don’t walk around with a name tag of your net worth in real life, so why should crypto be any different? Check out this Medium article for more information.</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@stop
