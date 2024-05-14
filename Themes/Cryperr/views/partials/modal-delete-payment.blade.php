<div class="modal fade" id="modalDeletePayment" tabindex="-1" aria-labelledby="modalDeletePayment" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-4 fs-sm-2">
                    Delete Payment Method
                </div>
                <img class="icon-close" src="{{ Theme::url('images/icon-close-fill.png') }}" data-bs-dismiss="modal"
                    aria-label="Close" alt="" />
            </div>
            <div class="modal-body">
                <div class="d-flex flex-nowrap justify-content-center mb-4">
                    <p class="text-center mb-3">Are you sure you want to delete this payment method?</p>
                </div>

                <div class="text-center">
                        <button class="btn btn-outline me-2" style="min-width: 120px; margin: auto">Cancel</button>
                        <button class="btn btn-primary ms-2" style="min-width: 120px; margin: auto">Confirm</button>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>
