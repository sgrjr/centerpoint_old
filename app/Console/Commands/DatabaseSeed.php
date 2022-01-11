<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class DatabaseSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed data in all tables managed in cp.config';

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
            $dm->seedTable($opt);
        }else{
            $dm->seedAllTables();
        }

        foreach($dm->results AS $result){
            $output->writeln($result->message);
        }

        return Command::SUCCESS;
    }
}
