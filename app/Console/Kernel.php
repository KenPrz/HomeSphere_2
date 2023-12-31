<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('modes:check')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/activate_modes.log'));
        $schedule->command('modes:deactivate')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/deactivate_modes.log'));
        $schedule->command('modes:env_check')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/env_check.log'));
        $schedule->command('devices:check')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/devices_check.log'));
        $schedule->command('sensor:update')
            ->everyThirtySeconds()
            ->appendOutputTo(storage_path('logs/sensor_update.log'));
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
