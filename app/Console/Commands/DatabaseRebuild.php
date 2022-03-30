<?php namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseRebuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:rebuild {shouldSeed?} {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuilds all tables managed in cp.config';

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
        $db_name = config("database.connections.mysql.database");
        \App\Helpers\DatabaseManager::rebuild($db_name, $this->argument('shouldSeed') === "seed", $this->argument('table'));
        return Command::SUCCESS;
    }
}
