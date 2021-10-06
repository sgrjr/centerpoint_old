<?php namespace App\Helpers;

use Carbon\Carbon, stdclass;

class UpdateDbfsIfChanged
{

	public function __construct($tables_to_update){

    if(is_string($tables_to_update)){
      $this->tablesToUpdate = explode(",",$tables_to_update);
    }else{
      $this->tablesToUpdate = $tables_to_update;
    }

		$file_name = "dbf_changes.json";


        if(file_exists($file_name)){
            $data = json_decode(file_get_contents($file_name));

            if(!is_object($data)){
                $data = $this->getInitialJSon($file_name);
                file_put_contents($file_name, json_encode($data, JSON_PRETTY_PRINT));
            }
        }else{
             $data = $this->getInitialJSon($file_name);
            file_put_contents($file_name, json_encode($data, JSON_PRETTY_PRINT));
        }

        if($data->pending === false){

        foreach($data->tables AS $tableId=>$table){
            
            $included = $this->tablesToUpdate? in_array($table->table, $this->tablesToUpdate):true;

            if($table->watch === true && $included){

                $dbfTable = $table->class::getDbfTable();

                foreach($table->sources AS $sourceId=>$source){
                  
                    $newTimeStamp =  filemtime ( $source->path );
                    //file_put_contents('timestamps.txt', $source->path ." NEW/OLD: " . $newTimeStamp . " - " .  $source->timestamp . "\n", FILE_APPEND);
                    $timeStampsTest = $newTimeStamp > $source->timestamp;
                    $shouldUpdateTest = $this->shouldUpdate($dbfTable, $source->headers, $source, $newTimeStamp);
                    $source->headers = $dbfTable->getHeader(); 

                   if( $timeStampsTest && $shouldUpdateTest){

                        $source->reviewed = 'PASSED_SHOULD_UPDATE';
                        $newOldTimeStamp = $source->timestamp;
                        $source->timestamp = $newTimeStamp;
                        $source->old_timestamp = $newOldTimeStamp;

                        $data->updates[] = ["time"=> Carbon::now(), "table"=>$source->path];

                        $data->pending = true;
                        $data->tables[$tableId]->sources[$sourceId] = $source;
 
                        file_put_contents($file_name, json_encode($data, JSON_PRETTY_PRINT));
                        
                        if (!\Schema::hasTable($table->table)) {
                            \Artisan::call('migrate');
                        }

                        \Artisan::call('db:seed --class='. ucfirst($table->table) .'TableSeeder');
                        $source->rebuilt = true;
                        
                        $source->reviewed = 'SEEDER_CALLED';
                        $data->tables[$tableId]->sources[$sourceId] = $source;
                        file_put_contents($file_name, json_encode($data, JSON_PRETTY_PRINT));
                        //$dbfTable->close();
                   }else{
                        $source->rebuilt = false;
                        $source->reviewed = 'DID_NOT_PASS_SHOULD_UPDATE' . 
                            '_TIMESTAMPS_' . ($timeStampsTest? 'PASSED':'FAILED') .
                            '_SHOULDUPDATE_' . ($shouldUpdateTest? 'PASSED':'FAILED') .
                            'INCLUDED' . ($included? 'INCLUDED':'NOT INCLUDED');
                        $data->tables[$tableId]->sources[$sourceId] = $source;
                        file_put_contents($file_name, json_encode($data, JSON_PRETTY_PRINT));

                   }

                   
                }
            }
        }
        $data->pending = false;
        file_put_contents($file_name, json_encode($data, JSON_PRETTY_PRINT));
    }
	}

	  public function getInitialJSon($file_name){
        $tables = \Config::get('cp')['tables'];

        $data = new stdclass;
        $data->updates = [];
        $data->pending = false;
        $data->tables = [];

        foreach($tables AS $table){
            $t = new stdclass;
            $t->class = $table[0];
            $model = new  $t->class;

            $t->table = $model->getTable();
            $t->watch = false;

            foreach( $model->getSeeds() AS $k=>$v){
                if($v['type'] === "dbf"){
                    $t->watch = true;
                    $source = new stdclass;
                    $source->timestamp = 0;
                    $source->old_timestamp = 0;
                    $source->rebuilt = false;
                    $source->reviewed = 'INITIALIZED';
                    $source->path = $v['path'];
                    $source->headers = false;
                    $t->sources[] = $source;

                }
            }

            $data->tables[] = $t;
        }

        return $data;
    }

    public function shouldUpdate($dbfTable, $headers, $source, $newTimeStamp){

        return true;

            if(
                $headers === false ||
                $headers->recordCount !== $dbfTable->getRecordCount() || 
                $headers->modifyDate < $dbfTable->getModifyDate()
                
            ){            
                return true;
            }
        

                /*
        App\Ask\DatabaseType\PHPXbase\XBaseWritableTable {#322 ▼
  +name: "C:\sites\Stephen_Reynolds\WEBINFO\RWDATA/webhead.DBF"
  +fp: stream resource @427 ▶}
  +isStream: false
  +filePos: 3400
  +recordPos: -1
  +record: false
  +version: 48
  +modifyDate: 1613520000
  +recordCount: 665
  +recordByteLength: 1738
  +inTransaction: false
  +encrypted: false
  +mdxFlag: "\x01"
  +languageCode: "\x03"
  +columns: array:97 [▶]
  +columnNames: array:97 [▶]
  +headerLength: 3400
  +backlist: "\r\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x ▶"
  +foxpro: true
  +deleteCount: 0
  +"skipMemo": true
  */
        $dbfTable->close();
        return false;
    }
}