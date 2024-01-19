<?php

return [
    'loyalty.packages' => [
        'index' => 'loyalty::packages.list resource',
        'create' => 'loyalty::packages.create resource',
        'edit' => 'loyalty::packages.edit resource',
        'destroy' => 'loyalty::packages.destroy resource',
    ],
    'loyalty.orders' => [
        'index' => 'loyalty::orders.list resource',
        'create' => 'loyalty::orders.create resource',
        'edit' => 'loyalty::orders.edit resource',
        'destroy' => 'loyalty::orders.destroy resource',
    ],
// append

];
