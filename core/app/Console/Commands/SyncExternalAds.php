<?php

namespace App\Console\Commands;

use App\Lib\ExternalAds\AdIngestor;
use App\Lib\ExternalAds\AdSourceManager;
use Illuminate\Console\Command;
use Throwable;

/**
 * Pulls PTC ads from the configured external source and upserts them as native
 * ads. Schedule it (see routes/console.php) so ads stay populated automatically
 * without anyone adding them from the dashboard.
 */
class SyncExternalAds extends Command
{
    protected $signature = 'ads:sync {--driver= : Override the configured ad source driver}';

    protected $description = 'Ingest dynamic PTC ads from the configured external source';

    public function handle(AdSourceManager $manager, AdIngestor $ingestor): int
    {
        if (!config('adsource.enabled')) {
            $this->warn('External ad source is disabled (config/adsource.php).');
            return self::SUCCESS;
        }

        $driverName = $this->option('driver') ?: config('adsource.driver', 'mock');

        try {
            $driver = $manager->driver($driverName);
            $ads    = $driver->fetch();
        } catch (Throwable $e) {
            $this->error("Failed to fetch ads from [$driverName]: {$e->getMessage()}");
            return self::FAILURE;
        }

        $result = $ingestor->sync($ads, $driverName);

        $this->info(sprintf(
            'Synced %d ads from [%s]: %d created, %d updated, %d deactivated.',
            count($ads),
            $driverName,
            $result['created'],
            $result['updated'],
            $result['deactivated'],
        ));

        return self::SUCCESS;
    }
}
