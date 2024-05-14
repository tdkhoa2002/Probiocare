<div class="container-custom">
    <div class="tab-order tabs">
        <div class="tabs-header">
            <ul class="tab-order-list nav nav-tabs" id="order-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#buyFromUser" type="button"
                        role="tab">
                        Buy From The Agent
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#sellFromUser" type="button"
                        role="tab">
                        Sell To The Agent
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="buyFromUser" role="tabpanel" tabindex="3">
                <div class="wrap-table d-none d-md-block mb-3">
                    <table class="table" style="min-width: 700px">
                        <thead>
                            <tr>
                                <th scope="col">Coin</th>
                                <th scope="col">Price: <span class="text-primary">Lowest</span>
                                </th>
                                <th scope="col">Available / Limit</th>
                                <th scope="col">Payment</th>
                                <th scope="col ">
                                    <div class="text-end">Trade: <span class="price-up">0
                                            Fee</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adsSell as $ad)
                                @php
                                    $iconUrl = Theme::url('images/logo.png');
                                    if ($ad->currency->getIcon()) {
                                        $icon = $ad->currency->getIcon();
                                        $iconCurrency = $icon->path;
                                    }
                                    $paymentMethods = $ad->paymentMethods;
                                    // if ($ad->CurrencyFiat->getIcon()) {
                                    // $icon = $ad->CurrencyFiat->getIcon();
                                    // $iconCurrencyFiat = $icon->path;
                                    // }
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img width="16px" height="16px" class="me-2" src="{{ $iconCurrency }}"
                                                alt="">
                                            {{ $ad->currency->code }} / <span
                                                class="ms-1 fw-light">{{ $ad->currencyFiat->code }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $ad->fixed_amount }} <span class="ms-1 fw-light">{{$ad->currencyFiat->code}}</span></td>
                                    <td>
                                        <div class="fw-light fs-7">
                                            Available: <span class="fs-6 fw-normal">
                                                {{ $ad->total_trade_amount - $ad->totaL_filled }}
                                                {{ $ad->currency->code }}</span>
                                        </div>
                                        <div class="fw-light fs-7">
                                            Limit: <span class="fs-6 fw-normal">
                                                {{ $ad->order_limit_min }}-{{ $ad->order_limit_max }}
                                                {{ $ad->currencyFiat->code }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @foreach ($paymentMethods as $p)
                                                <button class="btn btn-outline me-2 fs-7 py-0 px-2"
                                                    style="height: 36px">
                                                    {{ $p->title }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-end">
                                            <a class="btn btn-green"
                                                href="{{ route('fe.p2p.order.create', $ad->id) }}">
                                                BUY USDT
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (empty($adsSell))
                        @include('partials.table-empty')
                    @endif
                </div>
            </div>
            <div class="tab-pane" id="sellFromUser" role="tabpanel" tabindex="4">
                <div class="wrap-table d-none d-md-block mb-3">
                    <table class="table" style="min-width: 700px">
                        <thead>
                            <tr>
                                <th scope="col">Coin</th>
                                <th scope="col">Price: <span class="text-primary">
                                        Highest</span></th>
                                <th scope="col">Available / Limit</th>
                                <th scope="col">Payment</th>
                                <th scope="col ">
                                    <div class="text-end">Trade: <span class="price-up">0
                                            Fee</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($adsBuy as $ad)
                                @php
                                    $iconUrl = Theme::url('images/logo.png');
                                    if ($ad->currency->getIcon()) {
                                        $icon = $ad->currency->getIcon();
                                        $iconCurrency = $icon->path;
                                    }
                                    $paymentMethods = $ad->paymentMethods;
                                    // dd($paymentMethods);
                                    // if ($ad->CurrencyFiat->getIcon()) {
                                    // $icon = $ad->CurrencyFiat->getIcon();
                                    // $iconCurrencyFiat = $icon->path;
                                    // }
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img width="16px" height="16px" class="me-2" src="{{ $iconCurrency }}"
                                                alt="">
                                            {{ $ad->currency->code }} / <span
                                                class="ms-1 fw-light">{{ $ad->currencyFiat->code }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $ad->fixed_amount }} USD</td>
                                    <td>
                                        <div class="fw-light fs-7">
                                            Available: <span class="fs-6 fw-normal">
                                                {{ $ad->total_trade_amount - $ad->totaL_filled }}
                                                {{ $ad->currency->code }}</span>
                                        </div>
                                        <div class="fw-light fs-7">
                                            Limit: <span class="fs-6 fw-normal">
                                                {{ $ad->order_limit_min }}-{{ $ad->order_limit_max }}
                                                {{ $ad->currencyFiat->code }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @foreach ($paymentMethods as $p)
                                                <button class="btn btn-outline me-2 fs-7 py-0 px-2"
                                                    style="height: 36px">
                                                    {{ $p->title }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-end">
                                            <a class="btn btn-danger"
                                                href="{{ route('fe.p2p.order.create', $ad->id) }}">
                                                SELL USDT
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if (empty($adsBuy))
                        @include('partials.table-empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
