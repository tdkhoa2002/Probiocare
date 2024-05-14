@extends('layouts.private')

@section('title')
Loyalty | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')
<div class="loyalties-list">
        @foreach ($packages as $package)
        @php
        $cashback;
        $packageTermId;
        $bonusCredit = 0;
        $directCommission = 0;
        $termMatching = $package->term_matching;
        $packageTrans = $package->translations->first();
        if($packageTrans) {
            $title = $packageTrans->title;
        }
        // $packageCom0 = $package->commissions->first();
        // if($packageCom0 !== null) {
        //     $bonusCredit = $packageCom0->commission - 100;
        // }
        $packageTerm0 = $package->terms->first();
        if($packageTerm0 !== null) {
            $cashback = $package->min_stake / $packageTerm0->day_reward * $packageTerm0->apr_reward / 100;
            $packageTermId = $packageTerm0->id;
        }
        $currencyCashback = $package->currencyCashback;
        $commissions = $package->commissions;
        if($commissions) {
            foreach ($commissions as $key => $commission) {
                if($commission->level == 0) { // get Credit Bonus for himself
                    $bonusCredit = $commission->commission;
                }
                if($commission->level == 1) { // get F1 direct commission
                    $directCommission = $commission->commission;
                }
            }
        }

        $customer = auth()->guard('customer')->user();
        $subscribed = false;
        if ($package->getIcon()) {
            $icon = $package->getIcon();
            $iconUrl = $icon->path;
        } else {
            $iconUrl = Theme::url('images/logo.png');
        }
        @endphp
        <div class="loyalty-item">
            <div>
                <img src="{{ $iconUrl }}">
                <h4>{{ $title }}</h4>
                <div>
                    <input type="text" name="packageId" value="{{ $package->id }}" hidden>
                    <input type="text" name="term_id" value="{{ $packageTermId }}" hidden>
                    <input type="text" name ="amount" value="{{ $package->min_stake }}" hidden>
                    <div>
                        <span>Price</span>
                        <span name="amount">${{ $package->min_stake }}</span>
                    </div>
                    <div>
                        <span>Bonus Credit</span>
                        <span>{{ $bonusCredit }}%</span>
                    </div>
                    <div>
                        <span>Daily Cashback</span>
                        <span>{{ $cashback }} {{ $currencyCashback->code }} per day</span>
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
                @foreach ($orders as $order)
                    {{-- @php
                    dd($order);
                    @endphp --}}
                    @if ($order->term->package->id == $package->id)
                        @php
                            $subscribed = true;
                        @endphp
                        @break
                    @endif
                @endforeach

                @if ($subscribed)
                    <button type="button" class="btn btn-secondary btn-lg" disabled>Subscribed</button>
                @else
                    <a href="{{ route('fe.loyalty.loyalty.loyalty-detail', ['packageId' => $package->id, 'term' => $packageTermId]) }}">
                        <button type="submit" class="btn btn-success">Subcribe</button>
                    </a>
                @endif
        </div>
    </div>
        @endforeach
</div>
@stop