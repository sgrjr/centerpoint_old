<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		
		$config = \Config::get('cp');
        $list = [];
        foreach($config["tables"] AS $table){
            $list[] = \App\Helpers\Misc::modelNameToSeederName($table[0]);
		}
    
        //$list = ['BooktextsTableSeeder'];
         $this->call($list);

    }
}
