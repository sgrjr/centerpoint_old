<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class DatabaseTruncate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:truncate {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncates data in all tables managed in cp.config';

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
        $table = $this->argument('table');
        $dm = new \App\Helpers\DatabaseManager();
        $output = new ConsoleOutput();

        if(isset($table)){
            $opt = new \stdclass;
            $opt->name = $table;
            $dm->truncateTable($opt);
        }else{
            $dm->truncateAllTables();
        }

        foreach($dm->results AS $result){
            $output->writeln($result->message);
        }

        return Command::SUCCESS;
    }
}
