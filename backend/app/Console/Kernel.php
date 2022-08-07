<?php

namespace App\Console;

use App\Modules\Aws\Console\Commands\S3ImageRemoverCommand;
use App\Modules\Forms\Console\Commands\CreateDynamicFormsCommand;
use App\Modules\Sso\Console\Commands\SamlIdpCreateServiceProvider;
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
        S3ImageRemoverCommand::class,
        SamlIdpCreateServiceProvider::class,
        CreateDynamicFormsCommand::class, // php artisan dynamic-forms:create
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        //$schedule->command('send:emails')->everyFiveMinutes();
        $schedule->command('inspire')->everyMinute()->appendOutputTo('inspire.txt');

        // $schedule->command('send:deactivation-notice')->daily();
        //$schedule->command('deactivate:inactive-users')->daily();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
