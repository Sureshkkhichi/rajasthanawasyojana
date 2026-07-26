<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('allotments:cancel-expired', function (\App\Services\AllotmentExpiryService $service) {
    $this->info('Starting auto-cancellation of expired allotments...');
    $count = $service->expireOldAllotments();
    $this->info("Expired allotments cancelled successfully. Total processed: {$count}");
})->purpose('Cancel all unit allotments older than 7 days that are not sold.');

\Illuminate\Support\Facades\Schedule::call(function (\App\Services\AllotmentExpiryService $service) {
    $service->expireOldAllotments();
})->hourly();
