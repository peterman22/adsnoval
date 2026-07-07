<?php

namespace App\Lib\ExternalAds;

/**
 * Normalized ad returned by an ad source driver. Every driver maps its own
 * API response into this shape so the ingestor never needs to know where the
 * ad came from.
 */
class ExternalAd
{
    /**
     * @param string      $ref      Stable unique id from the source (idempotency key).
     * @param string      $title    Human readable ad title.
     * @param int         $adsType  1=website iframe, 2=image, 3=script/html, 4=youtube.
     * @param string      $adsBody  The creative: url / image path / html / youtube embed url.
     * @param float|null  $amount   Per-view payout (null = use config default).
     * @param int|null    $duration Watch seconds (null = use config default).
     * @param int|null    $maxShow  Inventory (null = use config default).
     * @param array       $schedule Optional day/time windows, same shape as native ads.
     */
    public function __construct(
        public string $ref,
        public string $title,
        public int $adsType,
        public string $adsBody,
        public ?float $amount = null,
        public ?int $duration = null,
        public ?int $maxShow = null,
        public array $schedule = [],
    ) {
    }
}
