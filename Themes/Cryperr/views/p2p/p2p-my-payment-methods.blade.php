<div class="payment-method py-3 py-md-4">
    <div class="d-flex align-item-start align-items-sm-center flex-column flex-sm-row mb-2">
        <div class="text fs-4 fw-medium me-3 mb-2 mb-md-0">Payment methods</div>
        <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalSelectPaymentDeposit"
            style="width: fit-content">
            <span class="me-2">+</span>
            Add payment method
        </button>
    </div>

    <p class="fs-7 fs-md-6 fw-light mb-3">
        P2P payment methods: When you sell cryptocurrencies, the payment method
        added will be
        displayed to
        buyer as options to accept payment, please ensure that the account
        owner’s name is
        consistent with
        your verified name on Metaviral Cex. You can add up to 20 payment
        methods.
    </p>
    <list-my-payment-method></list-my-payment-method>
    @include('partials.modal-delete-payment')
</div>

<div class="modalSelectPayment modal fade" id="modalSelectPaymentDeposit" tabindex="-1"
    aria-labelledby="modalSelectPaymentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-4 fs-sm-2">
                    Select Payment Method
                </div>
                <img class="icon-close" src="{{ Theme::url('images/icon-close-fill.png') }}" data-bs-dismiss="modal"
                    aria-label="Close" alt="" />
            </div>
            <div class="modal-body">
                <div class="bank-list bg-light rounded py-2">
                    @foreach ($paymentMethods as $item)
                    <a href="{{route('fe.customer.payment.get.create',$item->id)}}">
                        <div class="bank-item py-2 px-4">
                            {{$item->title}}
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>