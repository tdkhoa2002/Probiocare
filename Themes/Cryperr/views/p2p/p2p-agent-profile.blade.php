<div class="bg-secondary pb-4 mb-5">
    <div class="container-fluid">
        <div class="d-flex align-items-center">
            <div class="d-flex flex-column justify-content-between py-4">
                <div class="d-flex me-3">
                    <img class="pointer me-2" width="32px" height="32px" src="{{ Theme::url('images/logo.png') }}"
                        alt="">
                    @if($isAgent)
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <span class="email fs-7 fs-md-6 fw-medium me-2">
                                {{ $customer->profile->full_name ?? "" }}
                            </span>
                            <img class="pointer" width="18px" height="18px"
                                src="{{ Theme::url('images/icons/checked-round-blue.png') }}" alt="">
                        </div>
                        <span class="name fw-light">Join on {{ $customer->created_at ?? "" }}</span>
                    </div>
                    @endif
                    @if(!$isAgent)
                    <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#modalCreateMerchant">
                        Become merchant
                    </button>
                    @else
                    <a href="{{ route('fe.p2p.ads.create') }}" class="btn btn-primary ms-3">
                        <span class="me-2">+</span>
                        Post Ads
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <p2p-report-total></p2p-report-total>
    </div>
</div>

@php
    // Check required to become agent
$required_currency_id = setting('peertopeer::required_balance_merchant_currency');
$required_balance = 0;
$amount_required = setting('peertopeer::required_balance_merchant_amount');
if($customer->wallets){
$required_wallet = $customer->wallets()->where(function($q) use($required_currency_id){
return $q->where('currency_id', $required_currency_id);
})->first();
if($required_wallet) {
    $required_balance = $required_wallet->balance;
}
}
@endphp
<div class="modal fade" id="modalCreateMerchant" tabindex="-1" aria-labelledby="modalCreateMerchantLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title fs-4 fs-sm-2">
                    Register Merchant
                </div>
                <img class="icon-close" src="{{ Theme::url('images/icon-close-fill.png') }}" data-bs-dismiss="modal"
                    aria-label="Close" alt="" />
            </div>
            <div class="modal-body">
                <div class="fs-5 fw-medium mb-3">Requirements</div>
                <div class="d-flex align-items-center mb-3">
                    @if(!$customer->status_kyc)
                    <img width="24px" height="24px" class="me-2"
                        src="{{ Theme::url('images/icons/icon-checked-round.png') }}" alt="">
                    @else
                    <img width="24px" height="24px" class="me-2"
                        src="{{ Theme::url('images/icons/checked-round-blue.png') }}" alt="">
                    @endif
                    <div>Complete KYC</div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center ">

                        @if(!$required_balance >= $amount_required)
                        <img width="24px" height="24px" class="me-2"
                            src="{{ Theme::url('images/icons/icon-checked-round.png') }}" alt="">
                        @else
                        <img width="24px" height="24px" class="me-2"
                            src="{{ Theme::url('images/icons/checked-round-blue.png') }}" alt="">
                        @endif
                        <div>Wallet Balance {{ $amount_required }} MTV</div>
                    </div>
                    <button class="btn btn-primary">Deposit</button>
                </div>

                <div class="text-center">
                    @if($required_balance < $amount_required || !$customer->status_kyc)
                    <button class="btn btn-outline ms-2" disabled style="min-width: 120px; margin: auto">Apply
                        Now</button>
                    @else
                    <form action="{{route('fe.p2p.agent.post.apply')}}" method="POST">
                        @csrf
                        <button class="btn btn-primary ms-2" style="min-width: 120px; margin: auto">Apply Now</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>