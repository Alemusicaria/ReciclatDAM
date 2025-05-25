<?php

return [
    'name' => 'Reciclat DAM',
    'manifest' => [
        'name' => 'Reciclat DAM',
        'short_name' => 'ReciclatDAM',
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#388e3c',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        'permissions' => ['camera'],
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/icon-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images/icons/icon-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images/icons/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/icons/icon-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/icons/icon-384x384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => '/images/icons/icon-512x512.png',
                'purpose' => 'any maskable'
            ],
        ],
        'splash' => [
            '640x1136' => '/images/splash/splash-640x1136.png',
            '750x1334' => '/images/splash/splash-750x1334.png',
            '828x1792' => '/images/splash/splash-828x1792.png',
            '1125x2436' => '/images/splash/splash-1125x2436.png',
            '1242x2208' => '/images/splash/splash-1242x2208.png',
            '1242x2688' => '/images/splash/splash-1242x2688.png',
            '1536x2048' => '/images/splash/splash-1536x2048.png',
            '1668x2224' => '/images/splash/splash-1668x2224.png',
            '1668x2388' => '/images/splash/splash-1668x2388.png',
            '2048x2732' => '/images/splash/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Reciclaje',
                'description' => 'Ver información de reciclaje',
                'url' => '/#reciclatge',
                'icons' => [
                    "src" => "/images/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Premios',
                'description' => 'Ver premios disponibles',
                'url' => '/#premis',
                'icons' => [
                    "src" => "/images/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ]
        ],
        'custom' => []
    ]
];