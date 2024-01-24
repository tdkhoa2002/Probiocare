@extends('layouts.master')

@section('title')
Demo thanh toán Alepay | @parent
@stop

@section('content')
    <main>
    <div class="pt-4"></div>
    <div class="container">
        <h1>Demo thanh toán Alepay</h1>
        <p class="text-muted">Link action - route('web.alepay') == {{ route('alepay.shoppingcart.payment') }}, method="POST"</p>
        <form action="{{ route('alepay.shoppingcart.payment') }}" method="POST" class="form">
            @csrf
            <div class="row">
                <div class="table-title">
                    <img class="pointer" src="{{ Theme::url('images/icons/icon-delivery.png') }}" alt="">
                    <span>{{ __('shopping.delivery_option') }}</span>
                </div>
                <div class="box-form">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="delivery" id="delivery1"
                            value="1" checked>
                        <label class="form-check-label" for="delivery1"><span>{{ __('shopping.standard_delivery') }}</span></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="delivery" id="delivery2"
                            value="2">
                        <label class="form-check-label" for="delivery2"><span>{{ __('shopping.vip_delivery') }}</span></label>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="">Cancel URL (<span class="text-primary">cancelUrl</span>)</label>
                        <input type="text" name="cancelUrl" value="http://localhost:8000" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Giá trị đơn hàng (<span class="text-primary">amount</span>)</label>
                        <input type="number" name="amount" value="3000000" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Mô tả (<span class="text-primary">orderDescription</span>)</label>
                        <input type="text" name="orderDescription" value="Thanh toán qua Alepay" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Mã đơn hàng (<span class="text-primary">orderCode</span>)</label>
                        <input type="text" name="orderCode" class="form-control" value="452CA203D1">
                    </div>

                    <div class="form-group">
                        <label for="">Số lượng sản phẩm (<span class="text-primary">totalItem</span>)</label>
                        <input type="number" class="form-control" name="totalItem" value="2">
                    </div>

                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label for="">Họ và tên (<span class="text-primary">buyerName</span>)</label>
                        <input type="text" name="buyerName" value="Demo guy" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Email (<span class="text-primary">buyerEmail</span>)</label>
                        <input type="text" name="buyerEmail" value="demoguy@gmail.com" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Số điện thoại (<span class="text-primary">buyerPhone</span>)</label>
                        <input type="text" name="buyerPhone" value="0987456321" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ (<span class="text-primary">buyerAddress</span>)</label>
                        <input type="text" name="buyerAddress" value="Km10, Đường Nguyễn Trãi, Q.Hà Đông" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Thành phố (<span class="text-primary">buyerCity</span>)</label>
                        <input type="text" name="buyerCity" value="Hà Nội" class="form-control">
                    </div>
            </div>
            <div style="margin-bottom: 50px"></div>
            <button class="btn float-right btn-primary">Submit</button>
        </form>
    </div>

    <div class="mt-4"></div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </main>
@stop
