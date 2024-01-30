@php
$pkTrans = $package->translations->first();
$title = $pkTrans->title;
$commissions = $package->commissions;
$activities = false;
foreach ($commissions as $commission) {
if ($commission->level == 0 && $commission->status == true) {
$rewardAmount = $package->min_stake * $commission->commission / 100;
}
}
$currencyReward = $package->currencyReward->code;
$currencyCashback = $package->currencyCashback->code;
$currencyStake = $package->currencyStake->code;

$startDateFormatted = date("m/d/Y", strtotime($package->start_date));
$endDateFormatted = date("m/d/Y", strtotime($package->end_date));
$customer = auth()->guard('customer')->user();
// $packageCom0 = $package->commissions->first();
$bonusCredit = $package->principal_convert_rate;
$packageTerm0 = $package->terms->first();
$cashback = $package->min_stake / $packageTerm0->day_reward * $packageTerm0->apr_reward / 100;
foreach ($commissions as $commission) {
if($commission->level == 1) {
$directCommission = $commission->commission;
}
$termMatching = $commission->level;
}
if ($package->getIcon()) {
$icon = $package->getIcon();
$iconUrl = $icon->path;
} else {
$iconUrl = Theme::url('images/logo.png');
}

if(count($transactions) > 0) {
$activities = true;
}
$now = \Carbon\Carbon::now();
@endphp

@extends('layouts.private')

@section('title')
Package Detail | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')
<div class="back">
    <a href="{{ route('fe.loyalty.loyalty.list-packages') }}">
        <img src="{{ Theme::url('images/arrow-left.png') }}">
        <div class="label">Detail Package</div>
    </a>
</div>
<div id="detail-package">
    <div id="information-package">
        <form action="/loyalty/subcribeLoyalty" method="post">
            @csrf
            <input type="text" name="packageId" value="{{ $package->id }}" hidden>
            <input type="text" name="term_id" value="{{ $term }}" hidden>
            <input type="text" name="amount" value="{{ $package->min_stake }}" hidden>
            <div id="basic-info">
                <div id="icon-package">
                    <img src="{{ $iconUrl }}">
                </div>
                <div id="information">
                    <span id="title">{{ $title }}</span>
                    <div id="price-status">
                        <div id="price">
                            {{ $package->min_stake }} USD
                        </div>
                        @if ($now->gte($startDateFormatted) && $now->lte($endDateFormatted))
                        <div id="status" class="text-primary">
                            Active
                        </div>
                        @else
                        <div id="status" class="text-success">
                            Completed
                        </div>
                        @endif

                    </div>
                    <div style="color: #29292999;">This NFT will give you some unique benefits.</div>
                    <div id="customer-package">
                        <div>
                            <span>Owner</span>
                            <span id="owner">{{ $customer->profile->full_name }}</span>
                        </div>
                        <div>
                            <span>Product Credit</span>
                            <span>{{ $bonusCredit }}%</span>
                        </div>
                        <div>
                            <span>Daily Cashback</span>
                            <span>{{ $cashback }} {{ $currencyCashback }} per day</span>
                        </div>
                        <div>
                            <span>Direct Commission</span>
                            <span>{{ $directCommission }}%</span>
                        </div>
                        <div>
                            <span>Term Matching</span>
                            <span>{{ $termMatching }}</span>
                        </div>
                    </div>
                    @if(!isset($order))
                    <button class="btn btn-success" type="submit">
                        Subcribe
                    </button>
                    @endif
                </div>
            </div>
        </form>
        <div id="summary">
            <div>
                <span>Loyalty Summary</span>
            </div>
            <div id="content">
                <div>
                    <span>Valid From</span>
                    <span>{{ $startDateFormatted }}</span>
                </div>
                <div>
                    <span>Valid To</span>
                    <span>{{ $endDateFormatted }}</span>
                </div>
                {{-- <div>
                    <span>Loyalty Converted</span>
                    <span>{{ $rewardAmount }} {{ $currencyReward }}</span>
                </div> --}}
                <div>
                    <span>Earned Reward</span>
                    @if (!isset($order))
                    <span>0</span>
                    @else
                    <span>{{ $order->total_amount_reward }} {{ $currencyCashback }} </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div id="activities-package">
        <h4>Activities</h4>
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th scope="col">Amount</th>
                    <th scope="col">Event</th>
                    <th scope="col">Status</th>
                    <th scope="col">Txh</th>
                </tr>
            </thead>
            <tbody>
                @if ($activities)
                @foreach ($transactions as $transaction)
                <tr>
                    @if ($transaction->action == "SUBCRIBE_LOYALTY")
                    <th scope="row" style="color: #FF2F2F">-{{ $transaction->amount }} {{ $currencyStake }}</th>
                    @elseif($transaction->action == "COMMISSION_LOYALTY")
                    <th scope="row" style="color: #1A773B">+{{ $transaction->amount }} {{ $currencyReward }}</th>
                    @elseif($transaction->action == "REWARD_LOYALTY")
                    <th scope="row" style="color: #1A773B">+{{ $transaction->amount }} {{ $currencyCashback }}</th>
                    @endif

                    @if ($transaction->action == "SUBCRIBE_LOYALTY")
                    <td>Subcribe</td>
                    @elseif($transaction->action == "COMMISSION_LOYALTY")
                    <td>Commission Loyalty</td>
                    @elseif($transaction->action == "REWARD_LOYALTY")
                    <td>Reward Loyalty</td>
                    @endif

                    @if ($transaction->status == "COMPLETED")
                    <td style="color: #1A773B;">Completed</td>
                    @else
                    <td style="color: #FDC22A;">Processing</td>
                    @endif
                    <td>{{ $transaction->txhash }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop