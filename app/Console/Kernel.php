<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB, Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        "\App\Console\Commands\CreateDatabase",
        \App\Console\Commands\TwiceDailyUpdateCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   
        $schedule->call(function () {
           file_put_contents('schedule.txt',"running scheduler ". Carbon::now() . "\n", FILE_APPEND);
        })->everyMinute();

        $schedule->command('twicedaily:update')->twiceDaily(1,13);

        $schedule->call(function () {
            Artisan::call('db:seed --class=InventoriesTableSeeder');
        })->weekly();
    }
}
