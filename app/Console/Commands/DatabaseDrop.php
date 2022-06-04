<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseDrop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:drop {db_connection}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete MySQL database based on the database config file or the provided name';

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
        try{
            $schemaName = config("database.connections.".$this->argument('db_connection').".database");
            \App\Helpers\DatabaseManager::dropDatabaseIfExists($schemaName);
        }

        catch(\Exception\Exception $e){
            dd($e);
        }
    }
}