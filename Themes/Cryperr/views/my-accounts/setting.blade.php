@extends('layouts.private')

@section('title')
Setting | @parent
@stop
@section('content')
<div class="account-setting py-4 py-md-5">
    <div class="px-3 px-md-4">
        <div class="kyc-info bg-secondary rounded p-3 mb-3 mb-md-4">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 pb-md-3">
                <div class="d-flex flex-column me-4">
                    <h1 class="fs-5">Primary KYC</h1>
                    <p class="fw-light">Increase your daily withdrawal limits to up to $100 000.</p>
                </div>
                @if($customer->status_kyc == 0)
                <a href="{{route('fe.customer.customer.kyc')}}"><button class="btn btn-primary"
                        style="min-width: 120px">Verify</button></a>
                @elseif($customer->status_kyc === 1)
                <a href="#"><button class="btn btn-primary" style="min-width: 120px">Requested</button></a>
                @elseif($customer->status_kyc === 2)
                <a href="#"><button class="btn btn-secondary text-success"
                        style="min-width: 120px">Verified</button></a>
                @else
                <a href="{{route('fe.customer.customer.kyc')}}"><button class="btn btn-primary"
                        style="min-width: 120px">Re-Verify</button></a>
                @endif
            </div>
            @if($customer->status_kyc === 3)
            <div class="d-flex justify-content-between flex-wrap mt-2 mt-md-3 ">
                <div class="d-flex flex-nowrap mb-3 mb-md-0">
                    <div class="fw-light">
                        Reason :
                    </div>
                    <div>{{ $kyc->reason }}</div>
                </div>
            </div>
            @endif
            {{-- <div class="d-flex justify-content-between flex-wrap mt-2 mt-md-3 ">
                <div class="d-flex flex-nowrap mb-3 mb-md-0">
                    <div class="fw-light">
                        Nationality :
                    </div>
                    <div>Vietnam</div>
                </div>
                <div class="d-flex flex-nowrap  mb-3 mb-md-0">
                    <div class="fw-light">
                        Name :
                    </div>
                    <div>X******</div>
                </div>
                <div class="d-flex flex-nowrap">
                    <div class="fw-light">
                        ID Type :
                    </div>
                    <div>Passport</div>
                </div>
                <div class="d-flex flex-nowrap">
                    <div class="fw-light">
                        ID Type :
                    </div>
                    <div>****915812</div>
                </div>
            </div> --}}
        </div>

        <div class="px-2 px-md-4">
            <div class="d-flex justify-content-between align-items-center pb-3 pb-md-4">
                <div class="d-flex flex-column">
                    <div class="fs-6 fs-md-5 mb-2">Email Verification</div>
                    <div class="fs-7 fs-md-6 fw-light pe-4">
                        Increase your password strength to enhance account security
                    </div>
                </div>
                <a class="btn btn-secondary text-success" style="min-width: 120px">
                    Verified
                </a>
            </div>

            {{-- <div class="d-flex justify-content-between align-items-center pb-3 pb-md-4">
                <div class="d-flex flex-column">
                    <div class="fs-6 fs-md-5 mb-2">MetaViral Cex Wallet/Google Authenticator</div>
                    <div class="fs-7 fs-md-6 fw-light pe-4">
                        Set up your MetaViral Cex Wallet/Google Authenticator to provide an extra security
                    </div>
                </div>
                @if($customer->status_gg_auth !== 1)
                <a class="btn btn-primary" style="min-width: 120px">
                    Verify
                </a>
                @else
                <a class="btn btn-secondary text-success" style="min-width: 120px">
                    Verified
                </a>
                @endif
            </div> --}}

            {{-- <div class="d-flex justify-content-between align-items-center pb-3 pb-md-4">
                <div class="d-flex flex-column">
                    <div class="fs-6 fs-md-5 mb-2">Account Activity</div>
                    <div class="fs-7 fs-md-6 fw-light pe-4">
                        Last login: 2023-06-08 10:47
                    </div>
                </div>
                <a href="{{route('fe.customer.customer.activities')}}" class="btn btn-primary" style="min-width: 120px">
                    See more
                </a>
            </div> --}}

            {{-- <div class="d-flex justify-content-between align-items-center pb-3 pb-md-4">
                <div class="d-flex flex-column">
                    <div class="fs-6 fs-md-5 mb-2">Disable Account</div>
                    <div class="fs-7 fs-md-6 fw-light pe-4">
                        Disable your account immediately
                    </div>
                </div>
                <button class="btn btn-danger " style="min-width: 120px">
                    Delete!
                </button>
            </div> --}}
            {{-- <div class="d-flex justify-content-between align-items-center pb-3 pb-md-4">
                <div class="d-flex flex-column">
                    <div class="fs-6 fs-md-5 mb-2">Api Management</div>
                    <div class="fs-7 fs-md-6 fw-light pe-4">
                        Manage your api key
                    </div>
                </div>
                <a class="btn btn-primary " style="min-width: 120px" href="{{ route('fe.customer.customer.apiManagement') }}">
                    Manage
                </a>
            </div> --}}
            <div class="d-flex justify-content-between align-items-center pb-3 pb-md-4">
                <div class="d-flex flex-column">
                    <div class="fs-6 fs-md-5 mb-2">Logout Account</div>
                    <div class="fs-7 fs-md-6 fw-light pe-4">
                        Logout your account
                    </div>
                </div>
                <a class="btn btn-primary " style="min-width: 120px" href="{{ route('fe.customer.customer.logout') }}">
                    Logout
                </a>
            </div>
        </div>
    </div>
</div>
@stop