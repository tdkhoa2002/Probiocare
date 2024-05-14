<?php

return [
    'setting::themeOptions.general' => [
        'translatable' => [
            'site-name' => [
                'description' => 'core::settings.site-name',
                'view' => 'text'
            ],
            'site-name-mini' => [
                'description' => 'core::settings.site-name-mini',
                'view' => 'text'
            ],
            'site-description' => [
                'description' => 'core::settings.site-description',
                'view' => 'textarea'
            ]
        ]
    ],
    'setting::themeOptions.logo' => [
        'non-translatable' => [
            'logo' => [
                'description' => 'core::settings.logo',
                'view' => 'media-single'
            ],
            'logo_admin' => [
                'description' => 'core::settings.logo_admin',
                'view' => 'media-single'
            ],
            'favicon' => [
                'description' => 'core::settings.favicon',
                'view' => 'media-single'
            ],
        ]
    ]
];
