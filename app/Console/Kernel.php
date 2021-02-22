<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon, DB, Artisan;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        "\App\Console\Commands\CreateDatabase",
        \App\Console\Commands\TwiceDailyUpdateCommand::class,
        \App\Console\Commands\WatchDbfChanges::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   
       
        //$schedule->command('command:watchdbfchanges')->everyThirtyMinutes();

        $schedule->call(function () {
            file_put_contents("schedule.txt", "Schedule Ran: " . Carbon::now() . "\n", FILE_APPEND);
        })->everyThirtyMinutes();

        $schedule->call(function () {
            $update = new UpdateDbfsIfChanged(["webhead","webdetail","backhead","backdetail","brohead","brodetail"]);
        })->everyThirtyMinutes();

        $schedule->call(function () {
            $update = new UpdateDbfsIfChanged(["allhead","alldetail","ancienthead","anciendetail","booktext","inventory","vendor","password","passfile","standing_order"]);
        })->weekly();
    }
}
