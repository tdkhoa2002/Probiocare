<div class="modal fade" id="modalTxDetail" tabindex="-1" aria-labelledby="modalTxDetailLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-4 fs-sm-2">
                    Deposit Detail
                </div>
                <img class="icon-close" src="{{ Theme::url('images/icon-close-fill.png') }}" data-bs-dismiss="modal"
                    aria-label="Close" alt="" />
            </div>
            <div class="modal-body">
                <div class="d-flex nowrap mb-3">
                    <div class="count-num">1</div>
                    <div class="flex flex-column">
                        <div>Deposit order submitted</div>
                        <div class="fw-light">2023/06/06 14:33</div>
                    </div>
                </div>
                <div class="d-flex nowrap mb-3">
                    <div class="count-num">2</div>
                    <div class="flex flex-column">
                        <div>System processing
                        </div>
                        <div class="fw-light">2023/06/06 14:33</div>
                    </div>
                </div>
                <div class="d-flex nowrap mb-3">
                    <div class="count-num">3</div>
                    <div class="flex flex-column">
                        <div>Completed
                        </div>
                        <div class="fw-light">2023/06/06 14:33</div>
                    </div>
                </div>
                <div class="note">
                    <p class="text fw-light">Please note that you will receive a email once it is complete
                    </p>
                    <p class="text">Why hasn’t my deposit arrived ?</p>
                </div>

                <div class="tx-detail">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Time :</div>
                        <div class="time">2023-06-06   14:33</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Address :</div>
                        <div class="text-truncate" style="max-width: 200px">0xc4c16a64546466420024222b21a</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Network :</div>
                        <div class="time">BSC</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Coin :</div>
                        <div class="d-flex nowrap"><img src="{{ Theme::url('images/bnb.png') }}" alt="" width="24px" height="24px"><span class="ms-3">BCD</span></div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Fee :</div> 
                        <div class="time">0</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Amount :</div>
                        <div class="time">500</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="fw-light">Status :</div>
                        <div class="text-success">Completed</div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>
