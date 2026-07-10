<?php

return [
    // Spin the wheel: 8 slices. Cash prizes are winnable any time;
    // "free_ad" lands every Nth spin; "decoy" slices are never awarded.
    'spin' => [
        'free_ad_every' => 5,
        'segments' => [
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

    // Daily streak reward tiers (day-in-streak => reward).
    'streak' => [
        1 => 0.02, 2 => 0.03, 3 => 0.05, 5 => 0.10, 7 => 0.20, 14 => 0.40, 30 => 1.00,
    ],
];
