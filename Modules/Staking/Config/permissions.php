<?php

return [
    'staking.packages' => [
        'index' => 'staking::packages.list resource',
        'create' => 'staking::packages.create resource',
        'edit' => 'staking::packages.edit resource',
        'destroy' => 'staking::packages.destroy resource',
    ],
    'staking.orders' => [
        'index' => 'staking::orders.list resource',
        'detail' => 'staking::orders.detail resource'
    ],
// append





];
