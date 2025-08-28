<?php

namespace App\Console;

use App\Jobs\CreateFromRepresentanteNombramientosJob;
use App\Jobs\GenerateTaskInstancesJob;
use App\Jobs\PruneIvaHistoryJob;
use App\Jobs\SendNotificationsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Generate task instances daily
        $schedule->job(new GenerateTaskInstancesJob)->daily();

        // Create instances from representante nombramientos daily
        $schedule->job(new CreateFromRepresentanteNombramientosJob)->daily();

        // Send notifications every 15 minutes
        $schedule->job(new SendNotificationsJob)->everyFifteenMinutes();

        // Prune IVA history daily
        $schedule->job(new PruneIvaHistoryJob)->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}