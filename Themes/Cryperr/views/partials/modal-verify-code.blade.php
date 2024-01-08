<div class="modal fade" id="modalVerifyCode" tabindex="-1" aria-labelledby="modalVerifyCodeLabel" aria-hidden="true">
    @php
        $isEmailVerify = true;
    @endphp
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-4 fs-sm-2">
                    @if ($isEmailVerify)
                        Verification Code
                    @else
                        Google Authenticator
                    @endif
                </div>
                <img class="icon-close" src="{{ Theme::url('images/icon-close-fill.png') }}" data-bs-dismiss="modal"
                    aria-label="Close" alt="" />
            </div>
            <div class="modal-body">
                @if ($isEmailVerify)
                    <p class="text-center mb-3">Please check your email for OTP</p>
                @else
                    <p class="text-center mb-3">Please input your Authenticator Code</p>
                @endif

                <div class="wrap-input-code mb-2">
                    <div class="input-style">
                        <input type="text">
                    </div>
                    <div class="input-style">
                        <input type="text">
                    </div>
                    <div class="input-style">
                        <input type="text">
                    </div>
                    <div class="input-style">
                        <input type="text">
                    </div>
                    <div class="input-style">
                        <input type="text">
                    </div>
                    <div class="input-style">
                        <input type="text">
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <div class="fw-light">Resend in 50s</div>
                    <div class="text">Paste</div>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary" style="min-width: 120px; margin: auto">Next</button>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>
