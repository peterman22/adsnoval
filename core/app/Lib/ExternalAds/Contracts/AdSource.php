<?php

namespace App\Lib\ExternalAds\Contracts;

/**
 * A source of dynamic PTC ads. Implement this to pull from a real ad network:
 * fetch the network's campaigns and map each one to an ExternalAd.
 */
interface AdSource
{
    /**
     * Return the current set of ads from this source.
     *
     * @return \App\Lib\ExternalAds\ExternalAd[]
     */
    public function fetch(): array;
}
