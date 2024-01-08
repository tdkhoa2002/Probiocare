<?php

return [
    'setting::themeOptions.general' => [
        'translatable' => [
        ],
        'non-translatable' => [
        ]
    ],
    'Theme Appearance' => [
        'translatable' => [
        ],
        'non-translatable' => [
            'theme_primary_color' => [
                'description' => 'Primary Color',
                'view' => 'text',
                'translatable' => false,
            ],
            'theme_font_family' => [
                'description' => 'Font Family',
                'view' => 'text',
                'translatable' => false,
            ],
            'support_email' => [
                'description' => 'Support Email',
                'view' => 'text',
                'translatable' => false,
            ]
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
