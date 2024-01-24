<?php

return [
    'customer.customers' => [
        'index' => 'customer::customers.list resource',
        'create' => 'customer::customers.create resource',
        'edit' => 'customer::customers.edit resource',
        'destroy' => 'customer::customers.destroy resource',
    ],
    'customer.paymentmethods' => [
        'index' => 'customer::paymentmethods.list resource',
        'create' => 'customer::paymentmethods.create resource',
        'edit' => 'customer::paymentmethods.edit resource',
        'destroy' => 'customer::paymentmethods.destroy resource',
    ],
    'customer.wallets' => [
        'index' => 'customer::wallets.list resource',
        'create' => 'customer::wallets.create resource',
        'edit' => 'customer::wallets.edit resource',
        'destroy' => 'customer::wallets.destroy resource',
    ],
    'customer.transactions' => [
        'add_balance' => 'customer::transactions.add balance',
        'sub_balance' => 'customer::transactions.sub balance'
    ],
// append














];
