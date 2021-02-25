<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class WatchDbfChanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:watchdbfchanges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check dbfs for having been changed and if so then trigger a database update.';

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
        return new \App\Helpers\UpdateDbfsIfChanged();
    }

}
