<?php

return [
    'name' => 'BK SMP AL QADRI Islamic School',
    'manifest' => [
        'name' => 'Bimbingan Konseling SMP AL QADRI Islamic School',
        'short_name' => 'BK AL QADRI',
        'description' => 'Aplikasi Bimbingan dan Konseling SMP AL QADRI Islamic School - Mendampingi prestasi akademik dan pembentukan akhlak mulia siswa',
        'start_url' => '/',
        'background_color' => '#065f46', // Emerald green sesuai tema Islamic
        'theme_color' => '#059669', // Emerald theme
        'display' => 'standalone',
        'orientation' => 'portrait',
        'scope' => '/',
        'categories' => ['education', 'islamic', 'counseling'],
        'lang' => 'id',
        'dir' => 'ltr',
        'icons' => [
            [
                'src' => '/images/icons/icon-72x72.png',
                'sizes' => '72x72',
                'type' => 'image/png',
                'purpose' => 'any'
            ],
            [
                'src' => '/images/icons/icon-96x96.png',
                'sizes' => '96x96',
                'type' => 'image/png',
                'purpose' => 'any'
            ],
            [
                'src' => '/images/icons/icon-128x128.png',
                'sizes' => '128x128',
                'type' => 'image/png',
                'purpose' => 'any'
            ],
            [
                'src' => '/images/icons/icon-144x144.png',
                'sizes' => '144x144',
                'type' => 'image/png',
                'purpose' => 'any'
            ],
            [
                'src' => '/images/icons/icon-152x152.png',
                'sizes' => '152x152',
                'type' => 'image/png',
                'purpose' => 'any'
            ],
            [
                'src' => '/images/icons/icon-192x192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any'
            ],
            [
                'src' => '/images/icons/icon-384x384.png',
                'sizes' => '384x384',
                'type' => 'image/png',
                'purpose' => 'any'
            ],
            [
                'src' => '/images/icons/icon-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ]
        ],
        'screenshots' => [
            [
                'src' => '/images/screenshots/desktop-home.png',
                'sizes' => '1280x720',
                'type' => 'image/png',
                'form_factor' => 'wide',
                'label' => 'Dashboard Bimbingan Konseling'
            ],
            [
                'src' => '/images/screenshots/mobile-counseling.png',
                'sizes' => '375x812',
                'type' => 'image/png',
                'form_factor' => 'narrow',
                'label' => 'Layanan Konseling Mobile'
            ]
        ]
    ]
];
