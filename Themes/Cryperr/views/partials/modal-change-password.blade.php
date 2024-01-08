<div class="modal fade" id="modalChangePassword" tabindex="-1" aria-labelledby="modalChangePasswordLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-4 fs-sm-2">
                    Change Password
                </div>
                <img class="icon-close" src="{{ Theme::url('images/icon-close-fill.png') }}" data-bs-dismiss="modal"
                    aria-label="Close" alt="" />
            </div>
            <div class="modal-body">
                <form action="" class="row">
                    <div class="col-12">
                        <div class="form-item">
                            <label for="password" class="form-label">New Password</label>
                            <div class="input-group bg-light">
                                <input name="password" type="password" class="input" placeholder="New password">
                                <div class="ms-2">
                                    <img class="pointer" width="20px" src="{{ Theme::url('images/icons/eye.png') }}"
                                        alt="">
                                </div>
                            </div>
                            <div class="invalid-feedback d-lock">Error</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-item">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <div class="input-group bg-light">
                                <input name="confirmPassword" type="password" class="input"
                                    placeholder="Confirm password">
                                <div class="ms-2">
                                    <img class="pointer" width="20px" src="{{ Theme::url('images/icons/eye.png') }}"
                                        alt="">
                                </div>
                            </div>
                            <div class="invalid-feedback d-lock">Error</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-item">
                            <label for="verifyCode" class="form-label">Verify Code</label>
                            <input name="verifyCode" type="text" class="input" placeholder="Verify code">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="fw-light">Resend in 50s</div>
                            <div class="fw-medium">Paste</div>
                        </div>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <button class="btn btn-primary">Change</button>
                </div>

            </div>
        </div>
    </div>
</div>