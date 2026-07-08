<?php

/*
|--------------------------------------------------------------------------
| Engagement rewards: daily streak, spin-the-wheel & earnings calculator
|--------------------------------------------------------------------------
|
| Central, tweakable config for the retention features. Amounts are in the
| site's main currency. Keep payouts modest — every payout credits real
| balance that can be withdrawn.
|
*/

return [

    /*
    | Spin-the-wheel. One free spin per calendar day.
    |
    | Each segment has a display label and a `type`:
    |   - 'cash'    : credits `amount` to balance. `weight` = relative odds.
    |   - 'free_ad' : grants 1 free-ad credit. Only landed on every
    |                 `free_ad_every` spins (never via weight).
    |   - 'decoy'   : shown on the wheel for excitement but NEVER awarded
    |                 (the big $50 / $100 slices).
    | Order here = order of slices around the wheel.
    */
    'spin' => [
        'enabled'       => env('SPIN_ENABLED', true),
        'free_ad_every' => env('SPIN_FREE_AD_EVERY', 5), // 1 Free Ad wins on every Nth spin
        'segments'      => [
            ['label' => '$0.01',     'type' => 'cash',    'amount' => 0.01, 'weight' => 26],
            ['label' => '$50',       'type' => 'decoy',   'amount' => 50.0, 'weight' => 0],
            ['label' => '$0.03',     'type' => 'cash',    'amount' => 0.03, 'weight' => 22],
            ['label' => '1 Free Ad', 'type' => 'free_ad', 'amount' => 0.0,  'weight' => 0],
            ['label' => '$0.05',     'type' => 'cash',    'amount' => 0.05, 'weight' => 18],
            ['label' => '$100',      'type' => 'decoy',   'amount' => 100.0,'weight' => 0],
            ['label' => '$0.02',     'type' => 'cash',    'amount' => 0.02, 'weight' => 24],
            ['label' => '$0.08',     'type' => 'cash',    'amount' => 0.08, 'weight' => 12],
        ],
    ],

    /*
    | Daily streak. Claim once per calendar day; consecutive days increase the
    | reward up to the highest matching tier, then hold. A missed day resets
    | the streak to 1. Keyed by the day-in-streak the tier unlocks at.
    */
    'streak' => [
        'enabled' => env('STREAK_ENABLED', true),
        'tiers'   => [
            1  => 0.02,
            2  => 0.03,
            3  => 0.05,
            5  => 0.10,
            7  => 0.20,
            14 => 0.40,
            30 => 1.00,
        ],
    ],

    /*
    | Public earnings calculator (landing page). A representative average
    | payout per ad view, used to project daily/monthly earnings from a
    | plan's daily view limit. This is illustrative, not a guarantee.
    */
    'calculator' => [
        'avg_click_value' => env('CALC_AVG_CLICK_VALUE', 0.05),
        'referral_bonus'  => env('CALC_REFERRAL_BONUS', 0.10), // per referral/day illustrative
    ],
];
