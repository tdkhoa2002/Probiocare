<div class="bg-secondary pb-4 mb-5">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <div class="d-flex flex-column justify-content-between py-4">
                <div class="d-flex me-3">
                    <img class="pointer me-2" width="32px" height="32px" src="{{ Theme::url('images/logo.png') }}"
                        alt="">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <span class="email fs-7 fs-md-6 fw-medium me-2">
                                {{ $agent->profile->full_name ?? "" }}
                            </span>
                            <img class="pointer" width="18px" height="18px"
                                src="{{ Theme::url('images/icons/checked-round-blue.png') }}" alt="">
                        </div>
                        <span class="name fw-light">Join on {{ $agent->created_at }}</span>
                    </div>
                </div>
            </div>
        </div>
        <p2p-report-total :customer-id={{ $agent->id }}></p2p-report-total>
    </div>
</div>
