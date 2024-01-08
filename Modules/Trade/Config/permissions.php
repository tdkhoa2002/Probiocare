<?php

return [
    'trade.markets' => [
        'index' => 'trade::markets.list resource',
        'create' => 'trade::markets.create resource',
        'edit' => 'trade::markets.edit resource',
        'destroy' => 'trade::markets.destroy resource',
    ],
    'trade.trades' => [
        'index' => 'trade::trades.list resource',
        'cancelTrade' => 'trade::trades.cancelTrade',
    ],
    'trade.targetprices' => [
        'index' => 'trade::targetprices.list resource',
        'create' => 'trade::targetprices.create resource',
        'edit' => 'trade::targetprices.edit resource',
        'destroy' => 'trade::targetprices.destroy resource',
    ],
    'trade.volumnizers' => [
        'index' => 'trade::volumnizers.list resource',
        'create' => 'trade::volumnizers.create resource',
        'edit' => 'trade::volumnizers.edit resource',
        'destroy' => 'trade::volumnizers.destroy resource',
    ],
// append





];
