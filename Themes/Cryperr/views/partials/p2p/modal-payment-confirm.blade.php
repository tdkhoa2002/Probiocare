<div class="modalPaymentConfirm modal fade" id="modalPaymentConfirm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-4 fs-sm-2">
                    Payment Confirmation
                </div>
                <img class="icon-close" src="{{ Theme::url('images/icon-close-fill.png') }}" data-bs-dismiss="modal"
                    aria-label="Close" alt="" />
            </div>
            <div class="modal-body">
                <p class="fw-light mb-2">Please confirm that you have successfully received the funds from the buyer via the
                    following payment method before clicking the “Payment Received” button</p>
                <div class="light-card mb-3">
                    <div class="d-flex align-items-center mb-3">
                        <img class="me-2" width="24px" height="24px" src="{{ Theme::url('images/bank.png') }}"
                            alt="">
                        <span class="fw-medium">Bank Transfer</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Name :</div>
                        <div>John Olsen</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Bank account number :</div>
                        <div>032304124124</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Bank name :</div>
                        <div>ACB</div>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input">
                    <label for="" class="form-check-lable fw-light">I have confirmed that the payment was correct</label>
                </div>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-outline me-2">
                        Cancel
                    </button>
                    <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#modalVerifyCode">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
