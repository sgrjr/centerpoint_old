<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\ConsoleOutput;

class TestDbf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:dbf {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing to open, read, and write to DBF.';

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

        if($this->argument('name')){
            $name = ucfirst(strtolower($this->argument('name')));
            $class = "\\App\\Models\\".$name;
        }else{
            $class = \App\Models\Webdetail::class;
        }

        $output = new ConsoleOutput();
        $model = new $class;
        $table = $model->xTable();

        $table->open();
        $output->writeln($table->name);
        $output->writeln("There are " . $table->count() . " records.");
        $output->writeln("There are " . count($table->columns) . " columns.");

        foreach($table->columnNames AS $column){
            $output->write($column . " ");
        }

        $record = [];
        $record[$model->getKeyName()] = 9999990099;

        $newRecord = $table->save($record);

        $output->writeln('current record: '.$table->getRecord()->json());

        $counter = 0;
        $counterNotDeleted = 0;
        while($record = $table->nextRecord()){
            $counter++;
            if(!$record->isDeleted()) $counterNotDeleted++;
        }
      
        $output->writeln("\nI counted " . $counter . " of " . $table->count() . " records. NOT DELETED RECORDS TOTAL: " . $counterNotDeleted);

        $table->moveTo(1);
        $output->writeln(json_encode($table->record->getData()));

        $output->writeln("header length: ".$table->getHeader()->headerLength);

         /* xml output */
        file_put_contents("test_dbf.html", $table->toHTML(1000));

        /* NOW REMOVE NEWLY CREATED ENTRY and RECOUNT */
         $table->moveTo($newRecord['INDEX']);
         $table->getRecord()->delete();

         $table->moveTo(-1);

        $counter = 0;
        $counterNotDeleted = 0;
        while($record = $table->nextRecord()){
            $counter++;
             if(!$record->isDeleted()) $counterNotDeleted++;
        }

        $output->writeln("\nI counted " . $counter . " of " . $table->count() . " records. NOT DELETED RECORDS TOTAL: " . $counterNotDeleted);

        $table->close();
         
    }
}
