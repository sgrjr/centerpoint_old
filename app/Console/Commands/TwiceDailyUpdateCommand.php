<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class TwiceDailyUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twicedaily:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
            Artisan::call('db:seed --class=WebheadsTableSeeder');
            Artisan::call('db:seed --class=WebdetailsTableSeeder');
            Artisan::call('db:seed --class=BroheadsTableSeeder');
            Artisan::call('db:seed --class=BrodetailssTableSeeder');
            Artisan::call('db:seed --class=BackheadsTableSeeder');
            Artisan::call('db:seed --class=BackdetailsTableSeeder');
    }
}
