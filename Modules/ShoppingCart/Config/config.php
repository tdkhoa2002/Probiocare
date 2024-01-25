<?php

return [
    'name' => 'ShoppingCart',
    'check_auth' => env('SHOPPING_CHECK_AUTH'),
    'payment_methods' => [
        'alepay' => [
            'token_key' => env('ALEPAY_TOKEN_KEY'),
            'checksum_key' => env('ALEPAY_CHECKSUM_KEY'),
            'encrypt_key' => env('ALEPAY_ENCRYPT_KEY'),
            'base_api_url' => env('ALEPAY_BASE_API_URL'),
        ]
    ]
];
