<?php

use App\Console\Commands\SyncExternalAds;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Keep dynamic PTC ads populated automatically. Requires the system cron to
// run `php artisan schedule:run` every minute.
Schedule::command(SyncExternalAds::class)->hourly()->withoutOverlapping();
