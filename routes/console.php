<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule depreciation updates to run monthly
Schedule::command('depreciation:update')->monthly();

// Schedule expired consumables check to run daily
Schedule::command('consumables:check-expired')->daily();

// Schedule inventory reconciliation to run daily at 2 AM
Schedule::command('inventory:reconcile-quantities')->dailyAt('02:00');
