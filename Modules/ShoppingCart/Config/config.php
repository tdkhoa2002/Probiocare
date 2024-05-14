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
        ],
        'paypal' => [
            'mode'    => env('PAYPAL_MODE', 'sandbox'),
            'sandbox' => [
                'username'    => env('PAYPAL_SANDBOX_API_USERNAME', ''),
                'password'    => env('PAYPAL_SANDBOX_API_PASSWORD', ''),
                'secret'      => env('PAYPAL_SANDBOX_API_SECRET', ''),
                'certificate' => env('PAYPAL_SANDBOX_API_CERTIFICATE', ''),
                'app_id'      => 'APP-80W284485P519543T',
            ],

            'live' => [
                'username'    => env('PAYPAL_LIVE_API_USERNAME', ''),
                'password'    => env('PAYPAL_LIVE_API_PASSWORD', ''),
                'secret'      => env('PAYPAL_LIVE_API_SECRET', ''),
                'certificate' => env('PAYPAL_LIVE_API_CERTIFICATE', ''),
                'app_id'      => '',
            ],

            'payment_action' => 'Sale',
            'currency'       => env('PAYPAL_CURRENCY', 'VND'),
            'billing_type'   => 'MerchantInitiatedBilling',
            'notify_url'     => '',
            'locale'         => '',
            'validate_ssl'   => false,
        ]
    ]
];
