@extends('layouts.private')

@section('title')
My Package | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')
<div class="back">
    <a href="{{ route('fe.loyalty.loyalty.list-packages') }}">
        <img src="{{ Theme::url('images/arrow-left.png') }}">
        <div class="label">My Package</div>
    </a>
</div>
<div class="loyalties-list">
        @foreach ($packages as $package)
        @php
        $cashback;
        $packageTermId;
        $commission;
        $packageTrans = $package->translations->first();
        $title = $packageTrans->title;
        $packageCom0 = $package->commissions->first();
        if($packageCom0 !== null) {
            $commission = $packageCom0->commission - 100;
        }
        $packageTerm0 = $package->terms->first();
        if($packageTerm0 !== null) {
            $cashback = $package->min_stake / $packageTerm0->day_reward * $packageTerm0->apr_reward / 100;
            $packageTermId = $packageTerm0->id;
        }
        $currencyCashback = $package->currencyCashback;
        $commissions = $package->commissions;
        foreach ($commissions as $commission) {
            if($commission->level == 1) {
                $directCommission = $commission->commission;
            }
            $termMatching = $commission->level;
        }

        $customer = auth()->guard('customer')->user();
        if ($package->getIcon()) {
            $icon = $package->getIcon();
            $iconUrl = $icon->path;
        } else {
            $iconUrl = Theme::url('images/logo.png');
        }
        @endphp
        <div class="loyalty-item">
            <form action="/loyalty/subcribeLoyalty" method="post">
            @csrf
            <div>
                <img src="{{ $iconUrl }}">
                <a href="{{ route('fe.loyalty.loyalty.loyalty-detail', ['packageId' => $package->id, 'term' => $packageTermId]) }}" style="font-size: 20px; font-weight: 500; line-height:28px; color: #292929; margin-bottom: 10px;">{{ $title }}</a>
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
                        <span>{{ $commission->commission }}%</span>
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
                <button type="button" class="btn btn-secondary btn-lg" disabled>Subcribed</button>
            </form>
            </div>
        </div>
        @endforeach
</div>
@stop