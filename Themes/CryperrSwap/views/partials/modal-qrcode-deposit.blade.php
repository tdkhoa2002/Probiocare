<div class="modalQrCode modal fade" id="modalQrCodeDeposit" tabindex="-1" aria-labelledby="modalQrCodeLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-4 fs-sm-2">
                    Scan to Deposit
                </div>
                <img class="icon-close" src="{{ Theme::url('images/icon-close-fill.png') }}" data-bs-dismiss="modal"
                    aria-label="Close" alt="" />
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column justify-content-center">
                    <div id="qr-reader"></div>
                    <div class="text-center  mt-3"><span class="fw-light">Powered by</span> MetaViral Cex</div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
 
</div>
