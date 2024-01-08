<div class="resent-transaction">
    <h2 class="fs-4 mb-3">Recent Transation</h2>
    <div class="wrap-table">
        @if($transactions->count() >0)
        <table class="table" style="min-width: 700px">
            <thead>
                <tr>
                    <th scope="col">Time</th>
                    <th scope="col">Action</th>
                    <th scope="col">Network</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Currency</th>
                    <th scope="col">Txh</th>
                    <th scope="col text-end">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                @php
                if ($transaction->currency->getIcon()) {
                    $icon = $transaction->currency->getIcon();
                    $iconUrl = $icon->path;
                } else {
                    $iconUrl = Theme::url('images/logo.png');
                }
                $txhash = $transaction->txhash;
                $blockchain = $transaction->blockchain;
                $link = '';
                if ($transaction->status == 'COMPLETED') {
                    if($blockchain){
                        $link = $blockchain->scan . "/tx/" . $txhash;
                        $txhash = substr($txhash, 0, 10);
                    }elseif($transaction->action =='STAKING'||$transaction->action =='REWARD_STAKING') {
                        $link = route('fe.staking.staking.mystaking');
                    }
                }
                @endphp

                <tr data-bs-toggle="modal" data-bs-target="#modalTxDetail">
                    <td>
                        <div class="text">{{ $transaction->created_at }}</div>
                    </td>
                    <td>{{ $transaction->action }}</td>
                    <td>{{ $transaction->blockchain->title ?? "Internal"}}</td>
                    <td>{{ $transaction->amount >= 0.0001 ? $transaction->amount : number_format($transaction->amount, 8) }}</td>
                    <td class="row-name">
                        <div class="d-flex align-items-center">
                            <img class="me-2" width="32px" height="32px" src="{{ $iconUrl }}" alt="" />
                            <span class="symbol"> {{ $transaction->currency->code }} </span>
                        </div>
                    </td>
                    @if($link !="") 
                    <td><a href="{{ $link }}" target="_blank" rel="noopener noreferrer">{{ $txhash }}</a></td>
                    @else
                    <td>{{ $txhash }}</td>
                    @endif
                    <td><span class="box-status success">{{ $transaction->status }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {!! $transactions->links('partials.pagination') !!}
        @else
        <div class="table-empty">
            <img class="" width="36px" height="40px" src="{{ Theme::url('images/empty.png') }}" alt="">
            Empty
        </div>
        @endif
    </div>
</div>