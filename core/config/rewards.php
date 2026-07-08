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
    | Spin-the-wheel. One free spin per calendar day. Each segment has a
    | display label, a payout amount, and a weight (relative probability).
    | Higher weight = more likely. Order here = order around the wheel.
    */
    'spin' => [
        'enabled'  => env('SPIN_ENABLED', true),
        'segments' => [
            ['label' => '0.01', 'amount' => 0.01, 'weight' => 30],
            ['label' => '0.05', 'amount' => 0.05, 'weight' => 25],
            ['label' => '0.10', 'amount' => 0.10, 'weight' => 20],
            ['label' => '0.25', 'amount' => 0.25, 'weight' => 12],
            ['label' => '0.50', 'amount' => 0.50, 'weight' => 8],
            ['label' => '1.00', 'amount' => 1.00, 'weight' => 4],
            ['label' => 'JACKPOT', 'amount' => 5.00, 'weight' => 1],
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
