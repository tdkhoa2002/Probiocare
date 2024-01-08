<div class="modal fade" id="modalVerifyCodeStep" tabindex="-1" aria-labelledby="modalVerifyCodeStepLabel" aria-hidden="true">
    @php
        $isEmailVerify = false;
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
                <div class="d-flex flex-nowrap justify-content-between mb-4" style="max-width: 240px; margin: auto">
                    <div class="d-flex flex-nowrap">
                        <div class="round-checked me-2">
                            @php
                                $show = true;
                            @endphp
                            @if ($show)
                                <img src="{{ Theme::url('images/icons/icon-checked-round.png') }}" alt="" width="24px"
                                    height="24px">
                            @else
                                <img src="{{ Theme::url('images/icons/icon-round.png') }}" alt="" width="24px"
                                    height="24px">
                            @endif
                        </div>
                        <div class="">
                            EMAIL OTP
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="round-checked me-2">
                            @php
                                $show = true;
                            @endphp
                            @if ($show)
                                <img src="{{ Theme::url('images/icons/icon-checked-round.png') }}" alt="" width="24px"
                                    height="24px">
                            @else
                                <img src="{{ Theme::url('images/icons/icon-round.png') }}" alt="" width="24px"
                                    height="24px">
                            @endif
                        </div>
                        <div class="">
                            GG2FA
                        </div>
                    </div>
                </div>

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
                    @if ($isEmailVerify)
                        <button class="btn btn-primary" style="min-width: 120px; margin: auto">Next</button>
                    @else
                        <button class="btn btn-outline me-2" style="min-width: 120px; margin: auto">Back</button>
                        <button class="btn btn-primary ms-2" style="min-width: 120px; margin: auto">Done</button>
                    @endif
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>
