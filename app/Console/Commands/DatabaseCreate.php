<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class DatabaseCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:create {dataOrUi}';

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

        $connection = $this->argument('dataOrUi');
        $config = \Config::get('database');
        $database = Arr::get(Arr::get($config,"connections"), $connection);

        if (! $database) {
            $this->info('Skipping creation of database as env(DB_DATABASE) is empty');
            return;
        }

        try {
            $db_name = Arr::get($database, "database");
            $host = Arr::get($database, "host");
            $port  = Arr::get($database, "port");
            $username  = Arr::get($database, "username");
            $password  = Arr::get($database, "password");
            $charset = Arr::get($database, "charset");
            $collation = Arr::get($database, "collation");

            $pdo = $this->getPDOConnection($host, $port, $username, $password);

            $pdo->exec(sprintf(
                'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET %s COLLATE %s;',
                $db_name,
                $charset,
                $collation
            ));

            $this->info(sprintf('Successfully created %s database', $db_name));
        } catch (\PDOException $exception) {
            $this->error(sprintf('Failed to create %s database, %s', $db_name, $exception->getMessage()));
        }

    }

    private function getPDOConnection($host, $port, $username, $password)
    {
        return new \PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }

}
