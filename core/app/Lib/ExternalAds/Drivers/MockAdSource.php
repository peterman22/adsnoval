<?php

namespace App\Lib\ExternalAds\Drivers;

use App\Lib\ExternalAds\Contracts\AdSource;
use App\Lib\ExternalAds\ExternalAd;

/**
 * Placeholder ad source. Returns a deterministic set of demo ads so the whole
 * dynamic-ad pipeline can be run and verified without a real network. Swap
 * this out for a driver that calls a real API (see fetch() for the shape).
 */
class MockAdSource implements AdSource
{
    public function __construct(protected array $config = [])
    {
    }

    public function fetch(): array
    {
        $count = (int) ($this->config['count'] ?? 5);

        // A pool of varied creatives covering every ads_type the platform
        // renders. A real driver would build this list from an HTTP response.
        $pool = [
            ['type' => 1, 'body' => 'https://example.com/',                       'title' => 'Visit Example'],
            ['type' => 4, 'body' => 'https://www.youtube.com/embed/aqz-KE-bpKQ',  'title' => 'Watch Big Buck Bunny'],
            ['type' => 3, 'body' => '<div style="padding:40px;text-align:center;font-size:24px;">Sponsored: Try SuperWidget!</div>', 'title' => 'SuperWidget Promo'],
            ['type' => 1, 'body' => 'https://www.wikipedia.org/',                 'title' => 'Discover Wikipedia'],
            ['type' => 4, 'body' => 'https://www.youtube.com/embed/ScMzIvxBSi4',  'title' => 'Nature in 4K'],
            ['type' => 1, 'body' => 'https://openstreetmap.org/',                 'title' => 'Explore the Map'],
            ['type' => 3, 'body' => '<div style="padding:40px;text-align:center;font-size:24px;">Sponsored: Cloud hosting from $1</div>', 'title' => 'CloudHost Deal'],
        ];

        $ads = [];
        for ($i = 0; $i < $count; $i++) {
            $item = $pool[$i % count($pool)];
            $ads[] = new ExternalAd(
                ref: 'mock-' . ($i + 1),
                title: $item['title'],
                adsType: $item['type'],
                adsBody: $item['body'],
                // amount/duration/maxShow left null → config defaults apply.
            );
        }

        return $ads;
    }
}
