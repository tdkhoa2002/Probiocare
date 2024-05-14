<div class="modalP2pCancelOrder modal fade " id="modalP2pCancelOrder" tabindex="-1" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-4 fs-sm-2">
                    Cancel Order
                </div>
                <img class="icon-close" src="{{ Theme::url('images/icon-close-fill.png') }}" data-bs-dismiss="modal"
                    aria-label="Close" alt="" />
            </div>
            <div class="modal-body">
                <div class="fw-medium mb-2">Why did you cancel the order?</div>
                <p class="fw-light mb-3">We keep your feedback confidential and strive to serve you better next time.</p>

                <div class="fw-medium mb-3">Due to buyer</div>

                <div class="form-check form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions1" id="op1" value="option1" checked>
                    <label class="form-check-label" for="op1">I do not want to trade anymore</label>
                </div>

                <div class="form-check form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions1" id="op2" value="option2" >
                    <label class="form-check-label" for="op2">I do not meet the requirements of the advertiser’s trading terms and condition</label>
                </div>

                <div class="form-check form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions1" id="op3" value="option1" >
                    <label class="form-check-label" for="op3">Other reasons</label>
                </div>

                <div class="input-group bg-light mb-3">
                    <input type="text" class="input" placeholder="Please enter your reasons">
                </div>

                <div class="fw-medium mb-3">Due to seller</div>

                <div class="form-check form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions2" id="op4" value="option1" >
                    <label class="form-check-label" for="op4">Seller is asking for extra fee</label>
                </div>

                <div class="form-check form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions2" id="op5" value="option1" >
                    <label class="form-check-label" for="op5">Problem with seller’s payment method result in unsuccessful payment</label>
                </div>

                <div class="form-check form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions2" id="op6" value="option1" checked>
                    <label class="form-check-label" for="op6">Other reasons</label>
                </div>

                <div class="input-group bg-light mb-3">
                    <input type="text" class="input" placeholder="Please enter your reasons">
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="agree">
                    <label for="agree" class="form-check-lable fw-light">I have not paid the seller / seller has agree to refund</label>
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
