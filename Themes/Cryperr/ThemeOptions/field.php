<?php

return [
    'setting::themeOptions.general' => [
        'translatable' => [
        ],
        'non-translatable' => [
            'phone' => [
                'description' => 'theme::setting.phone',
                'view' => 'text',
                'translatable' => false,
            ],
            'email' => [
                'description' => 'theme::setting.email',
                'view' => 'text',
                'translatable' => false,
            ],
            'facebook' => [
                'description' => 'theme::setting.facebook',
                'view' => 'text',
                'translatable' => false,
            ],
            'twitter' => [
                'description' => 'theme::setting.twitter',
                'view' => 'text',
                'translatable' => false,
            ],
        ]
    ],
    'Theme Appearance' => [
        'translatable' => [
        ],
        'non-translatable' => [
            'theme_primary_color' => [
                'description' => 'theme::setting.theme_primary_color',
                'view' => 'text',
                'translatable' => false,
            ],
        ]
    ],
    'Home Option' => [
        'translatable' => [
            'registered_user' => [
                'description' => 'Registered_user',
                'view' => 'text',
                'translatable' => true,
            ],
            'transaction_fee' => [
                'description' => 'Transaction Fee',
                'view' => 'text',
                'translatable' => true,
            ],
            'cryptocurrencies' => [
                'description' => 'Cryptocurrencies',
                'view' => 'text',
                'translatable' => true,
            ],
            'trading_pairs' => [
                'description' => 'Trading Pairs',
                'view' => 'text',
                'translatable' => true,
            ],
        ],
        'non-translatable' => [
           
        ]
    ]
];
