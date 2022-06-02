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
    protected $signature = 'test:dbf';

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
        $output = new ConsoleOutput();
        $table = (new \App\Models\Webdetail)->xTable();

        $table->open();
        $output->writeln($table->name);
        $output->writeln("There are " . $table->count() . " records.");
        $output->writeln("There are " . count($table->columns) . " columns.");

        foreach($table->columnNames AS $column){
            $output->write($column . " ");
        }

        $record = ["INDEX"=>1341,"DATE"=> "20220401", "REQUESTED"=>43, "REMOTEADDR"=>77777, "DELETED"=> false, "ADDDD"=>7];

        $table->save($record);

        $output->writeln('current record: '.$table->getRecord()->json());

        $counter = 0;
        while($record = $table->nextRecord()){
            //$output->writeln($record->getData()["TITLE"]);
            $counter++;
        }
      
        $output->writeln("\nI counted " . $counter . " of " . $table->count() . " records.");

        $table->moveTo(1335);
        $output->writeln($table->record->getData()["TITLE"]);

        $output->writeln("header length: ".$table->getHeader()->headerLength);

         /* xml output */
        file_put_contents("test_dbf.html", $table->toHTML(1000));

        $table->close();
         
    }
}
