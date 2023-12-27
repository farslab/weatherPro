<?php

namespace App\Console;

use App\Jobs\ApiRequestJob;
use App\Jobs\PrayerTimeApi;
use Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->job(new ApiRequestJob)->everyMinute()->onFailure(function () {
        //     Log::info('ApiRequest Job failed.');
        // });
        $schedule->job(new PrayerTimeApi)->everyMinute()->onFailure(function () {
            Log::info('PrayerTimeApi failed.');
        });


    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
