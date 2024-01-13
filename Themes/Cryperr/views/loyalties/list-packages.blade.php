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
        $commission;
        $packageTrans = $package->translations->first();
        $title = $packageTrans->title;
        $packageCom0 = $package->commissions->first();
        if($packageCom0 !== null) {
            $commission = $packageCom0->commission - 100;
        }
        $packageTerm0 = $package->terms->first();
        if($packageTerm0 !== null) {
            $cashback = round($package->min_stake / $packageTerm0->day_reward, 2);
            $packageTermId = $packageTerm0->id;
        }
        $currencyCashback = $package->currencyCashback;
        $commissions = $package->commissions;
        foreach ($commissions as $commission) {
            if($commission->level == 1) {
                $directCommission = $commission->commission;
            }
        }

        $customer = auth()->guard('customer')->user();
        // foreach ($orders as $order) {
        //     dd($order->term->package->id);
        // }
        @endphp
        <div class="loyalty-item">
            <form action="/loyalty/subcribeLoyalty" method="post">
            @csrf
            <div>
                <img src="{{ Theme::url('images/icon-package.png') }}">
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
                        <span>1</span>
                    </div>
                </div>
                @if(count($orders) > 0)
                    @foreach ($orders as $order)
                        @if ($order->term->package->id == $package->id)
                            <button type="button" class="btn btn-secondary btn-lg" disabled>Subcribed</button>
                        @else
                        <button type="submit" class="btn btn-success">Subcribe</button>
                        @endif
                    @endforeach
                @else
                    <button type="submit" class="btn btn-success">Subcribe</button>
                @endif
            </form>
            </div>
        </div>
        @endforeach
</div>
@stop