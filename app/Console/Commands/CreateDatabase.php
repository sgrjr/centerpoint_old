<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the base database for the application';

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
     * @return mixed
     */
    public function handle()
    {

        $config = \Config::get('database');
        $database = array_get(array_get($config,"connections"), "mysql");

        if (! $database) {
            $this->info('Skipping creation of database as env(DB_DATABASE) is empty');
            return;
        }

        try {
            $db_name = array_get($database, "database");
            $host = array_get($database, "host");
            $port  = array_get($database, "port");
            $username  = array_get($database, "username");
            $password  = array_get($database, "password");
            $charset = array_get($database, "charset");
            $collation = array_get($database, "collation");

            $pdo = $this->getPDOConnection($host, $port, $username, $password);

            $pdo->exec(sprintf(
                'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET %s COLLATE %s;',
                $db_name,
                $charset,
                $collation
            ));

            $this->info(sprintf('Successfully created %s database and seeded tables.', $db_name));

        } catch (\PDOException $exception) {
            $this->error(sprintf('Failed to create %s database, %s', $db_name, $exception->getMessage()));
        }

        \Artisan::call('migrate');
        \Artisan::call('passport:client --personal');

        $tables = ["webheads","webdetails","backheads","backdetails","broheads","brodetails","allheads","alldetails","ancientheads","anciendetails","booktexts","inventories","vendors","users","passfiles","standing_orders"];

        $change = new \App\Helpers\UpdateDbfsIfChanged($tables);


    }

    private function getPDOConnection($host, $port, $username, $password)
    {
        return new \PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }

}
