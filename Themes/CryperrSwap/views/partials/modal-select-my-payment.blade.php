<div class="modalSelectMyPayment modal fade" id="modalSelectMyPayment" tabindex="-1" aria-labelledby="modalSelectMyPayment"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-4 fs-sm-2">
                    Payment Methods
                </div>
                <img class="icon-close" src="{{ Theme::url('images/icon-close-fill.png') }}" data-bs-dismiss="modal"
                    aria-label="Close" alt="" />
            </div>
            <div class="modal-body">
                <div class="mb-2">Select payment method</div>
                <div class="payment-list rounded py-2">
                    <a href="#">
                        <div class="payment-item bg-light rounded py-3 px-4 mb-2">
                            <div class="left-border fw-light mb-2"> Bank Transfer</div>
                            <div class="d-flex justify-content-between">
                                <div class="name fw-medium">John Olsen</div>
                                <div class="name fw-medium">576767676</div>
                            </div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="payment-item bg-light rounded py-3 px-4">
                            <div class="left-border fw-light mb-2"> Alipay</div>
                            <div class="d-flex justify-content-between">
                                <div class="name fw-medium">John Olsen</div>
                                <div class="name fw-medium">576767676</div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="text-center mt-3"> <button class="btn btn-text">Manage payment methods</button> </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>
