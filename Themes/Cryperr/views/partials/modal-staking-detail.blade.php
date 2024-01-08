<div class="modal fade" id="modalStakingDetail" tabindex="-1" aria-labelledby="modalStakingDetailLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-4 fs-sm-2">
                    Staking Information
                </div>
                <img class="icon-close" src="{{ Theme::url('images/icon-close-fill.png') }}" data-bs-dismiss="modal"
                    aria-label="Close" alt="" />
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="count-num line"></div>
                        <div>Stake Date</div>
                    </div>
                    <div class="fw-light">2023/06/06 14:33</div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="count-num line"></div>
                        <div>Value Date
                        </div>
                    </div>
                    <div class="fw-light">2023/06/06 14:33</div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="count-num"></div>
                        <div>End Date
                        </div>
                    </div>
                    <div>Flexible</div>
                </div>
                <div class="tx-detail">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Type :</div>
                        <div class="time">Flexible</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Staked Amount :</div>
                        <div class="">0.5 BNB</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Est APR :</div>
                        <div>2%</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Est Reward :</div>
                        <div class="">0.5 BNB</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="fs-5 fw-medium">Redeem Amount</div>
                </div>
                <div class="input-group bg-light mb-2">
                    <input type="text" class="input" placeholder="Please enter the amount">
                    <div class="suffix fw-medium">
                        Max
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="fs-7 fw-medium">Amount Limitation</div>
                    <div class="fs-7">100 OPV</div>
                </div>

                <div class="text-center mt-3">
                    <button class="btn btn-primary">Redeem</button>
                </div>

            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>
