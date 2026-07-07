<?php

/*
|--------------------------------------------------------------------------
| External Ad Source (dynamic PTC ads)
|--------------------------------------------------------------------------
|
| Configuration for automatically ingesting PTC ads from an external source
| instead of creating each ad by hand from the dashboard. The "mock" driver
| ships enabled so the feature can be demonstrated end-to-end; swap the
| driver (and add its credentials) to pull from a real ad network.
|
*/

return [

    // Master switch. When false, `php artisan ads:sync` does nothing.
    'enabled' => env('AD_SOURCE_ENABLED', true),

    // Which driver to pull ads from. See App\Lib\ExternalAds\AdSourceManager.
    'driver' => env('AD_SOURCE_DRIVER', 'mock'),

    /*
    | Defaults applied to every ingested ad. A real driver can override any of
    | these per-ad; the mock driver uses them as-is. `amount` is what a viewer
    | earns per view, so keep it below the real per-view revenue of the source.
    */
    'defaults' => [
        'amount'   => env('AD_SOURCE_AMOUNT', 0.50),   // payout per view
        'duration' => env('AD_SOURCE_DURATION', 10),    // watch seconds
        'max_show' => env('AD_SOURCE_MAX_SHOW', 1000),  // inventory per ad
    ],

    /*
    | Ingested ads are platform-owned (no advertiser to bill/refund), so they
    | are stored against this user_id. 0 keeps them clear of real advertiser
    | accounts and matches how admin-created system ads are treated.
    */
    'owner_id' => env('AD_SOURCE_OWNER_ID', 0),

    /*
    | Ads that disappear from the source on a later sync can be auto-paused so
    | they stop being served. Set false to leave stale ads active.
    */
    'deactivate_missing' => env('AD_SOURCE_DEACTIVATE_MISSING', true),

    /*
    | Per-driver options. Add a block keyed by driver name.
    */
    'drivers' => [

        'mock' => [
            // How many placeholder ads the mock driver returns.
            'count' => env('AD_SOURCE_MOCK_COUNT', 5),
        ],

        // Example real driver scaffold (not implemented — shown for shape):
        // 'adsterra' => [
        //     'endpoint' => env('ADSTERRA_ENDPOINT'),
        //     'api_key'  => env('ADSTERRA_API_KEY'),
        // ],
    ],
];
