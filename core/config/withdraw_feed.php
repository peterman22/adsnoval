<?php

/*
|--------------------------------------------------------------------------
| Withdrawal ticker ("proof of payment") feed
|--------------------------------------------------------------------------
|
| Controls the live payout ticker shown on the dashboard and landing page.
|
| NOTE: "generated" entries are simulated social-proof, not real payouts.
| Use 'real' if you only want to show genuine approved withdrawals.
|
*/

return [

    // 'generated' = simulated only, 'real' = genuine approved withdrawals only,
    // 'mixed' = real ones first, topped up with generated entries.
    'mode' => env('WITHDRAW_FEED_MODE', 'generated'),

    // How many entries the ticker shows.
    'count' => env('WITHDRAW_FEED_COUNT', 15),

    // A new simulated entry appears every N minutes (list advances by one).
    'interval_minutes' => env('WITHDRAW_FEED_INTERVAL', 5),

    // Simulated amount range.
    'min_amount' => env('WITHDRAW_FEED_MIN', 53),
    'max_amount' => env('WITHDRAW_FEED_MAX', 7305),

    // Bias: >1 skews toward smaller amounts (big payouts stay rare). 1 = uniform.
    'skew' => env('WITHDRAW_FEED_SKEW', 2.4),

    // Running "total paid out" headline number.
    'total_base'        => env('WITHDRAW_FEED_TOTAL_BASE', 1250000),
    'total_per_day'     => env('WITHDRAW_FEED_TOTAL_PER_DAY', 8400),
    'total_anchor_date' => env('WITHDRAW_FEED_TOTAL_ANCHOR', '2025-01-01'),

    // Payout methods drawn at random for simulated entries.
    'methods' => ['USDT', 'Bitcoin', 'PayPal', 'Bank Transfer', 'Payeer', 'Perfect Money', 'Skrill', 'Litecoin', 'BNB'],

    // First-name pool used to build believable, then-masked usernames.
    'names' => [
        'james', 'mary', 'john', 'patricia', 'robert', 'jennifer', 'michael', 'linda', 'william', 'elizabeth',
        'david', 'susan', 'richard', 'jessica', 'joseph', 'sarah', 'thomas', 'karen', 'chris', 'nancy',
        'daniel', 'lisa', 'paul', 'betty', 'mark', 'sandra', 'donald', 'ashley', 'george', 'kimberly',
        'kenneth', 'emily', 'steven', 'donna', 'edward', 'michelle', 'brian', 'carol', 'ronald', 'amanda',
        'anthony', 'melissa', 'kevin', 'deborah', 'jason', 'stephanie', 'jeff', 'rebecca', 'gary', 'laura',
        'ahmed', 'fatima', 'wei', 'ling', 'raj', 'priya', 'carlos', 'sofia', 'ivan', 'olga',
    ],
];
