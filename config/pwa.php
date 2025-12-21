<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Would you like the install button to appear on all pages?
      Set true/false
    |--------------------------------------------------------------------------
    */

    'install-button' => true,

    /*
    |--------------------------------------------------------------------------
    | PWA Manifest Configuration
    |--------------------------------------------------------------------------
    |  php artisan erag:update-manifest
    */

    'manifest' => [
        'name' => 'HealthGrade',
        'short_name' => 'HealthGrade',
        'background_color' => '#005461',
        'display' => 'standalone',
        'description' => 'Scan nutrisi & grade makanan dengan AI',
        'theme_color' => '#018790',
        'icons' => [
            [
                'src' => 'icons/icon-72x72.png',
                'sizes' => '72x72',
                'type' => 'image/png',
            ],
            [
                'src' => 'icons/icon-96x96.png',
                'sizes' => '96x96',
                'type' => 'image/png',
            ],
            [
                'src' => 'icons/icon-128x128.png',
                'sizes' => '128x128',
                'type' => 'image/png',
            ],
            [
                'src' => 'icons/icon-144x144.png',
                'sizes' => '144x144',
                'type' => 'image/png',
            ],
            [
                'src' => 'icons/icon-152x152.png',
                'sizes' => '152x152',
                'type' => 'image/png',
            ],
            [
                'src' => 'icons/icon-192x192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any maskable',
            ],
            [
                'src' => 'icons/icon-384x384.png',
                'sizes' => '384x384',
                'type' => 'image/png',
            ],
            [
                'src' => 'icons/icon-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any maskable',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Configuration
    |--------------------------------------------------------------------------
    | Toggles the application's debug mode based on the environment variable
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Livewire Integration
    |--------------------------------------------------------------------------
    | Set to true if you're using Livewire in your application to enable
    | Livewire-specific PWA optimizations or features.
    */

    'livewire-app' => false,
];
