@extends('layouts.private')

@section('title')
Staking & Earn | @parent
@stop
{{-- @section('meta')
<meta name="title" content="{{ $page->meta_title }}" />
<meta name="description" content="{{ $page->meta_description }}" />
@stop --}}

@section('content')
<div class="staking-list py-4 py-md-5">
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-2 mb-sm-4">
            <div class="backlink">
                <div class="label">Staking List</div>
            </div>

            <div class="right-search">
                <form action="" method="get">
                    <div class="input-group" onclick="handleShowInputOnMobile(this)">
                        <img src="{{ Theme::url('images/icons/search.png') }}" alt="" width="24px" height="24px">
                        <input id="stakingListSearch" class="input" type="text" name="currency" value="{{ request()->get('currency') }}"
                            placeholder="Search Curency">
                    </div>
                </form>
                <script>
                    function handleShowInputOnMobile() {
                            if (window.innerWidth < 576) {
                                $('#stakingListSearch').css('display', 'block')
                            }
                        }
                </script>
            </div>
        </div>

        {{-- Desktop --}}
        <div class="wrap-table mb-4">
            <table class="table" style="min-width: 800px">
                <thead>
                    <tr>
                        <th>
                            Stake Currency
                        </th>
                        <th>
                            Reward Currency
                        </th>
                        <th>
                            Principal Currency
                        </th>

                        <th>
                            <div class="d-flex flex-wrap justify-content-center pointer">
                                Duration (Days)
                            </div>
                        </th>
                        <th>
                            <div class="d-flex flex-wrap justify-content-center pointer">
                                <div>
                                    APR
                                </div>
                                {{-- <span class="ms-1 ms-md-3">
                                    <svg width="11" height="16" viewBox="0 0 11 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.92358 15.5673C6.42391 16.1442 5.52886 16.1442 5.02919 15.5673L1.26103 11.2162C0.558242 10.4047 1.1347 9.14286 2.20823 9.14286H9.74455C10.8181 9.14286 11.3945 10.4047 10.6917 11.2162L6.92358 15.5673Z"
                                            fill="#FFC700" />
                                        <path
                                            d="M5.02563 0.432727C5.5253 -0.144242 6.42036 -0.144242 6.92003 0.432727L10.6882 4.78382C11.391 5.59534 10.8145 6.85714 9.74099 6.85714H2.20467C1.13114 6.85714 0.554684 5.59534 1.25748 4.78382L5.02563 0.432727Z"
                                            fill="#989898" />
                                    </svg>
                                </span> --}}
                            </div>
                        </th>
                        <th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $package)
                    @php
                    $iconUrl = Theme::url('images/logo.png');
                    $iconStakeUrl = Theme::url('images/logo.png');
                    $iconRewardUrl = Theme::url('images/logo.png');
                    $iconPrincipal = Theme::url('images/logo.png');
                    $currencyPrincipal = $package->currencyStake->code;
                    if ($package->currencyStake->getIcon()) {
                    $icon = $package->currencyStake->getIcon();
                    $iconStakeUrl = $icon->path;
                    $iconPrincipal = $icon->path;
                    }

                    if ($package->currencyReward->getIcon()) {
                    $icon = $package->currencyReward->getIcon();
                    $iconRewardUrl = $icon->path;
                    }
                    $packageTerms = $package->terms;
                    $minAPR = 0;
                    $maxAPR = 0;
                    if($package->principal_is_stake_currency==false){
                    $iconPrincipal = $iconRewardUrl;
                    $currencyPrincipal = $package->currencyReward->code;
                    }
                    @endphp
                    <tr>
                        <td>
                            <a href="#">
                                <div class="d-flex align-items-center flex-nowrap text-nowrap">
                                    <img class="me-1" width="16px" height="16px" src="{{ $iconStakeUrl }}"
                                        alt="" />{{$package->currencyStake->code}}
                                </div>
                            </a>
                        </td>
                        <td>
                            <a href="#">
                                <div class="d-flex align-items-center flex-nowrap text-nowrap">
                                    <img class="me-1" width="16px" height="16px" src="{{ $iconRewardUrl }}"
                                        alt="" />{{$package->currencyReward->code}}
                                </div>
                            </a>
                        </td>
                        <td>
                            <a href="#">
                                <div class="d-flex align-items-center flex-nowrap text-nowrap">
                                    <img class="me-1" width="16px" height="16px" src="{{ $iconPrincipal }}" alt="" />{{
                                    $currencyPrincipal}}
                                </div>
                            </a>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center flex-nowrap">
                                @foreach ($packageTerms as $term)
                                @php
                                $minAPR = ($minAPR === 0) ? $term->apr_reward : $minAPR;
                                $minAPR = ($minAPR > $term->apr_reward) ? $term->apr_reward : $minAPR;
                                $maxAPR = ($maxAPR < $term->apr_reward) ? $term->apr_reward : $maxAPR;
                                    $termDefault = $term->id;
                                    @endphp
                                    <a href="{{route('fe.staking.staking.staking-detail',$package->id)}}?term={{$term->id}}"
                                        class="btn btn-duration ms-1 me-1">
                                        @if ($term->type === 'FLEXIBLE')
                                        FLEXIBLE
                                        @else
                                        {{$term->day_reward}}
                                        @endif
                                    </a>
                                    @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="text-center price-up">
                                {{$minAPR}}%-{{$maxAPR}}%
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <a
                                    href="{{route('fe.staking.staking.staking-detail',$package->id)}}?term={{$termDefault}}">
                                    <button class="btn btn-primary text-nowrap">
                                        Stake Now
                                    </button>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- Mobile --}}
        <div class="package-list">
            @foreach ($packages as $package)
            @php
            $iconUrl = Theme::url('images/logo.png');
            if ($package->currencyStake->getIcon()) {
            $icon = $package->currencyStake->getIcon();
            $iconStakeUrl = $icon->path;
            }

            if ($package->currencyReward->getIcon()) {
            $icon = $package->currencyReward->getIcon();
            $iconRewardUrl = $icon->path;
            }
            $packageTerms = $package->terms;
            $minAPR = 0;
            $maxAPR = 0;
            // dd($packageTerms);
            @endphp
            <div class="package-item">
                <div class="d-flex justify-content-between mb-3">
                    <div>Stake Currency:</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ $iconStakeUrl }}" alt="" />
                            <span>
                                {{$package->currencyStake->code}}
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Reward Currency:</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ $iconRewardUrl }}" alt="" />
                            <span>
                                {{$package->currencyReward->code}}
                            </span>
                        </div>
                    </a>
                </div>
                
                <div class="d-flex justify-content-between mb-3">
                    <div>Duration (Days) :</div>
                    <div class="durations">
                        @foreach ($packageTerms as $term)
                            @php
                            $minAPR = ($minAPR === 0) ? $term->apr_reward : $minAPR;
                            $minAPR = ($minAPR > $term->apr_reward) ? $term->apr_reward : $minAPR;
                            $maxAPR = ($maxAPR < $term->apr_reward) ? $term->apr_reward : $maxAPR;
                            $termDefault = $term->id;
                            @endphp
                            <a href="{{route('fe.staking.staking.staking-detail',$package->id)}}?term={{$term->id}}"
                                class="btn flexible ">
                                @if ($term->type === 'FLEXIBLE')
                                FLEX
                                @else
                                {{$term->day_reward}}
                                @endif
                            </a>
                            @endforeach
                            {{-- <button class="btn active flexible">Flexible</button>
                            <button class="btn">60</button>
                            <button class="btn">90</button>
                            <button class="btn">120</button> --}}
                    </div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>APR :</div>
                    <div class="price-up">{{$minAPR}}%-{{$maxAPR}}%</div>
                </div>
                <div class="text-center mt-2">
                    <a href="{{route('fe.staking.staking.staking-detail',$package->id)}}?term={{$termDefault}}">
                        <button class="btn btn-primary">
                            Stake Now
                        </button>
                    </a>
                </div>
            </div>
            @endforeach
            {{-- <div class="package-item">
                <div class="d-flex justify-content-between mb-3">
                    <div>Coin:</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Reward Coin :</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>APR :</div>
                    <div class="price-up">12.5%</div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Duration (Days) :</div>
                    <div class="durations">
                        <button class="btn active flexible">Flexible</button>
                        <button class="btn">60</button>
                        <button class="btn">90</button>
                        <button class="btn">120</button>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="/staking-detail">
                        <button class="btn btn-primary">
                            Stake Now
                        </button>
                    </a>
                </div>
            </div>
            <div class="package-item">
                <div class="d-flex justify-content-between mb-3">
                    <div>Coin:</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Reward Coin :</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>APR :</div>
                    <div class="price-up">12.5%</div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Duration (Days) :</div>
                    <div class="durations">
                        <button class="btn active flexible">Flexible</button>
                        <button class="btn">60</button>
                        <button class="btn">90</button>
                        <button class="btn">120</button>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="/staking-detail">
                        <button class="btn btn-primary">
                            Stake Now
                        </button>
                    </a>
                </div>
            </div>
            <div class="package-item">
                <div class="d-flex justify-content-between mb-3">
                    <div>Coin:</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Reward Coin :</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>APR :</div>
                    <div class="price-up">12.5%</div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Duration (Days) :</div>
                    <div class="durations">
                        <button class="btn active flexible">Flexible</button>
                        <button class="btn">60</button>
                        <button class="btn">90</button>
                        <button class="btn">120</button>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="/staking-detail">
                        <button class="btn btn-primary">
                            Stake Now
                        </button>
                    </a>
                </div>
            </div>
            <div class="package-item">
                <div class="d-flex justify-content-between mb-3">
                    <div>Coin:</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Reward Coin :</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>APR :</div>
                    <div class="price-up">12.5%</div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Duration (Days) :</div>
                    <div class="durations">
                        <button class="btn active flexible">Flexible</button>
                        <button class="btn">60</button>
                        <button class="btn">90</button>
                        <button class="btn">120</button>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="/staking-detail">
                        <button class="btn btn-primary">
                            Stake Now
                        </button>
                    </a>
                </div>
            </div>
            <div class="package-item">
                <div class="d-flex justify-content-between mb-3">
                    <div>Coin:</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Reward Coin :</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>APR :</div>
                    <div class="price-up">12.5%</div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Duration (Days) :</div>
                    <div class="durations">
                        <button class="btn active flexible">Flexible</button>
                        <button class="btn">60</button>
                        <button class="btn">90</button>
                        <button class="btn">120</button>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="/staking-detail">
                        <button class="btn btn-primary">
                            Stake Now
                        </button>
                    </a>
                </div>
            </div>
            <div class="package-item">
                <div class="d-flex justify-content-between mb-3">
                    <div>Coin:</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Reward Coin :</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>APR :</div>
                    <div class="price-up">12.5%</div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Duration (Days) :</div>
                    <div class="durations">
                        <button class="btn active flexible">Flexible</button>
                        <button class="btn">60</button>
                        <button class="btn">90</button>
                        <button class="btn">120</button>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="/staking-detail">
                        <button class="btn btn-primary">
                            Stake Now
                        </button>
                    </a>
                </div>
            </div>
            <div class="package-item">
                <div class="d-flex justify-content-between mb-3">
                    <div>Coin:</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Reward Coin :</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>APR :</div>
                    <div class="price-up">12.5%</div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Duration (Days) :</div>
                    <div class="durations">
                        <button class="btn active flexible">Flexible</button>
                        <button class="btn">60</button>
                        <button class="btn">90</button>
                        <button class="btn">120</button>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="/staking-detail">
                        <button class="btn btn-primary">
                            Stake Now
                        </button>
                    </a>
                </div>
            </div>
            <div class="package-item">
                <div class="d-flex justify-content-between mb-3">
                    <div>Coin:</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Reward Coin :</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>APR :</div>
                    <div class="price-up">12.5%</div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Duration (Days) :</div>
                    <div class="durations">
                        <button class="btn active flexible">Flexible</button>
                        <button class="btn">60</button>
                        <button class="btn">90</button>
                        <button class="btn">120</button>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="/staking-detail">
                        <button class="btn btn-primary">
                            Stake Now
                        </button>
                    </a>
                </div>
            </div>
            <div class="package-item">
                <div class="d-flex justify-content-between mb-3">
                    <div>Coin:</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Reward Coin :</div>
                    <a href="/staking-list-pair?pair=wbnb-usdt">
                        <div class="d-flex align-items-center flex-nowrap text-nowrap">
                            <img class="me-1" width="24px" height="24px" src="{{ Theme::url('images/bnb.png') }}"
                                alt="" />
                            <span>
                                WBNB
                            </span>
                        </div>
                    </a>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>APR :</div>
                    <div class="price-up">12.5%</div>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <div>Duration (Days) :</div>
                    <div class="durations">
                        <button class="btn active flexible">Flexible</button>
                        <button class="btn">60</button>
                        <button class="btn">90</button>
                        <button class="btn">120</button>
                    </div>
                </div>
                <div class="text-center mt-2">
                    <a href="/staking-detail">
                        <button class="btn btn-primary">
                            Stake Now
                        </button>
                    </a>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@stop