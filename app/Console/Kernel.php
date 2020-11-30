<?php

namespace App\Console;

use App\Console\Commands\FileMigrateToS3;
use App\Console\Commands\GenerateContentDispositionCommands;
use App\Console\Commands\RegenerateProformaInvoice;
use App\Console\Commands\RegenerateProformaInvoiceNumbers;
use App\Console\Commands\SendProformaInvoice;
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
        FileMigrateToS3::class,
        RegenerateProformaInvoice::class,
        RegenerateProformaInvoiceNumbers::class,
        SendProformaInvoice::class,
        GenerateContentDispositionCommands::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('telescope:prune')->daily();
        $schedule->command('queue:work --once')->everyMinute()->withoutOverlapping();
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
