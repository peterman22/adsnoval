<?php

return [
    'name' => 'AdsNoval',
    'short_name' => 'AdsNoval',
    'start_url' => '/',
    'background_color' => '#ffffff',
    'theme_color' => '#ff6600',
    'display' => 'standalone',
    'orientation' => 'portrait',
    'status_bar' => '#ff6600',

    'icons' => [
        '192x192' => [
            'path' => '/images/icons/icon-192x192.png',
            'purpose' => 'any'
        ],
        '512x512' => [
            'path' => '/images/icons/icon-512x512.png',
            'purpose' => 'any'
        ]
    ],

    'splash' => [
        '640x1136' => '/images/splash/640x1136.png',
        '750x1334' => '/images/splash/750x1334.png',
        '828x1792' => '/images/splash/828x1792.png',
        '1125x2436' => '/images/splash/1125x2436.png',
        '1242x2688' => '/images/splash/1242x2688.png',
    ],

    'custom' => []
];
