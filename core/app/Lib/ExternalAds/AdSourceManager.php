<?php

namespace App\Lib\ExternalAds;

use App\Lib\ExternalAds\Contracts\AdSource;
use App\Lib\ExternalAds\Drivers\MockAdSource;
use InvalidArgumentException;

/**
 * Resolves the configured ad source driver. Register new drivers here (or bind
 * them in a service provider) so `config('adsource.driver')` can select them.
 */
class AdSourceManager
{
    public function driver(?string $name = null): AdSource
    {
        $name ??= config('adsource.driver', 'mock');
        $options = config("adsource.drivers.$name", []);

        return match ($name) {
            'mock'  => new MockAdSource($options),
            // 'adsterra' => new Drivers\AdsterraSource($options),
            default => throw new InvalidArgumentException("Ad source driver [$name] is not supported."),
        };
    }
}
