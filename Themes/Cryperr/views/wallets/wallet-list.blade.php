{{-- @php
    $customer = auth()->guard('customer')->user();
    $wallets = $customer->wallets;
    $curren
@endphp --}}
@extends('layouts.private')

@section('title')
Wallet | @parent
@stop
@section('content')
{{-- <wallet-my-assets></wallet-my-assets> --}}
<div class="wallet">
    <div class="wallet-head">
        <div class="left">
            <h1 class="page-title">
                Balance (USD)
            </h1>
            <div class="balance">
                $<span id="total_balance_usd"></span>
            </div>
        </div>
        <div class="actions-list ">
            <a href="{{ route('fe.wallet.wallet.deposit') }}"><button class="btn btn-primary">Deposit</button></a>
            <a href="{{ route('fe.wallet.wallet.withdraw') }}"><button class="btn btn-outline">Withdraw</button></a>
            <a href="{{ route('fe.staking.staking.mystaking') }}"><button class="btn btn-outline">Earn</button></a>
            <a href="{{ route('fe.wallet.wallet.history') }}"><button class="btn btn-outline">History</button></a>
        </div>
    </div>
    <wallet-list :wallets="{{ $wallets }}"></wallet-list>
    {{--<div class="wallet-list">
        <div class="wallet-list-head">
            <div class="table-title">
                Your Asset
            </div>
            <div class="right-action">
                <div class="form-check form-switch form-check-reverse">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckReverse">
                    <label class="form-check-label" for="flexSwitchCheckReverse">Hide Small balance</label>
                </div>
                <div class="field-search input-group px-1">
                    <div class="input-prefix pe-2">
                        <img src="{{ Theme::url('images/icons/search.png') }}" alt="">
                    </div>
                    <input type="text" class="input" placeholder="Search Curency">
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Currency</th>
                    <th scope="col">Amount</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($currencies as $key => $currency)
                @foreach ($wallets as $wallet)
                @php
                    $walletCurrency = $wallet->currency;
                @endphp
                @if($walletCurrency &&$currency->code === $wallet->currency->code)
                <tr class="hide-small-balance">
                    <td onclick="toggleDrawerTokenDetail(this, true)">
                        <div class="d-flex align-items-center">
                            @php
                            if ($wallet->currency->getIcon()) {
                            $icon = $wallet->currency->getIcon();
                            $iconUrl = $icon->path;
                            } else {
                            $iconUrl = Theme::url('images/logo.png');
                            }
                            $wallet_usdt = $wallet->balance * $wallet->currency->usd_rate;
                            @endphp
                            <img class="me-2" width="32px" height="32px" src="{{ $iconUrl }}" alt="" />
                            <div class="d-flex flex-column">
                                <span class="symbol"> {{ $wallet->currency->code }} </span>
                                <span class="name text-span fs-7"> {{ $wallet->currency->title }} </span>
                            </div>
                        </div>
                    </td>
                    <td onclick="toggleDrawerTokenDetail(this, true)">
                        <div class="d-flex flex-column">
                            <div class="balance">{{ $wallet->balance }}</div>
                            <div class="price text-span fs-7">${{ $wallet_usdt }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="actions">
                            <a class="action"
                                href="{{ route('fe.wallet.wallet.deposit') }}?currency={{ $wallet->currency->code }}">
                                <img width="24px" class="me-1" src="{{ Theme::url('images/icon-deposit.png') }}" alt="">
                                <span class="text">Deposit</span>
                            </a>
                            <a class="action"
                                href="{{ route('fe.wallet.wallet.withdraw') }}?currency={{ $wallet->currency->code }}">
                                <img width="24px" class="me-1" src="{{ Theme::url('images/icon-withdraw.png') }}"
                                    alt="">
                                <span class="text">Withdraw</span>
                            </a>
                            <a class="action"
                                href="{{ route('fe.trade.trade.list') }}?currency={{ $wallet->currency->code }}">
                                <img width="24px" class="me-1" src="{{ Theme::url('images/icon-trade.png') }}" alt="">
                                <span class="text">Trade</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @php
                    unset($currencies[$key]);
                    break;
                @endphp
                @endif
                @endforeach
                @endforeach

                @foreach ($currencies as $key => $currency)
                <tr class="hide-small-balance">
                    <td onclick="toggleDrawerTokenDetail(this, true)">
                        <div class="d-flex align-items-center">
                            @php
                            if ($currency->getIcon()) {
                            $icon = $currency->getIcon();
                            $iconUrl = $icon->path;
                            } else {
                            $iconUrl = Theme::url('images/logo.png');
                            }
                            @endphp
                            <img class="me-2" width="32px" height="32px" src="{{ $iconUrl }}" alt="" />
                            <div class="d-flex flex-column">
                                <span class="symbol"> {{ $currency->code }} </span>
                                <span class="name text-span fs-7"> {{ $currency->title }} </span>
                            </div>
                        </div>
                    </td>
                    <td onclick="toggleDrawerTokenDetail(this, true)">
                        <div class="d-flex flex-column">
                            <div class="balance">0</div>
                            <div class="price text-span fs-7">$0</div>
                        </div>
                    </td>
                    <td>
                        <div class="actions">
                            <a class="action"
                                href="{{ route('fe.wallet.wallet.deposit') }}?currency={{ $currency->code }}">
                                <img width="24px" class="me-1" src="{{ Theme::url('images/icon-deposit.png') }}" alt="">
                                <span class="text">Deposit</span>
                            </a>
                            <a class="action"
                                href="{{ route('fe.wallet.wallet.withdraw') }}?currency={{ $currency->code }}">
                                <img width="24px" class="me-1" src="{{ Theme::url('images/icon-withdraw.png') }}"
                                    alt="">
                                <span class="text">Withdraw</span>
                            </a>
                            <a class="action" href="{{ route('fe.trade.trade.list') }}?currency={{ $currency->code }}">
                                <img width="24px" class="me-1" src="{{ Theme::url('images/icon-trade.png') }}" alt="">
                                <span class="text">Trade</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>--}}
</div>
@stop

{{-- @include('partials.drawer-tokeninfo') --}}
{{-- @push('js-stack')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const switchElement = document.getElementById('flexSwitchCheckReverse');
        const rowsToToggle = document.querySelectorAll('.hide-small-balance');
        switchElement.addEventListener('change', function () {
            const hideSmallBalance = switchElement.checked;
            console.log("======================");
            rowsToToggle.forEach(row => {
                console.log(row);
                const balanceElement = row.querySelector('.balance');
                const balance = parseFloat(balanceElement.textContent);

                const threshold = 0;

                row.style.display = hideSmallBalance && balance == threshold ? 'none' : '';
            });
        });
        });
    </script>
@endpush --}}