<?php namespace App\Ask;

use App\Ask\DatabaseType\PHPXbase\XBaseTable;
use App\Ask\DatabaseType\Config\ConfigTable;
use App\Ask\DatabaseType\PHPXbase\XBaseWritableTable as WritableTable;
use App\Ask\DatabaseType\PHPXbase\XBaseTable as Table;
use Config;
use \Illuminate\Pagination\LengthAwarePaginator;
use App\Ask\AskInterface\AskQueryBuilderInterface;
use Illuminate\Database\Eloquent\Builder;
use App\Ask\QueryBuilder;


class XbaseQueryBuilder extends QueryBuilder implements AskQueryBuilderInterface {

   /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection;

public function source(){
    return 'dbf';
}

public function setTable(){
        $this->table = [];

        foreach($this->model->getSeeds() AS $seed){

        	if($this->writable && $seed["type"] === "dbf"){
		        $table = new WritableTable($seed["path"]);
				$this->table[] = $table;
		    }else if( $seed["type"] === "dbf"){
		        $table = new Table($seed["path"]);
				$this->table[] = $table;
		    }

		     

        }

    return $this;
}

	public function with($name){
		$this->children->push($name);
		return $this;
	}

	public function where($column, $comparison, $value){
		$this->parameters->tests[] = [$column, $comparison, $value];
		return $this;
	}

	public function setPage($pageValue){
		$this->parameters->page = $pageValue;
		return $this;
	}

public function findByIndex($index, $columns = false){
	return $this->index($index, $columns);
}

public function find($primaryKeyValue){
	return $this
		->setPerPage(1)
		->setPage(1)
		->where($this->model->getDbfPrimaryKey(),"===", $primaryKeyValue)
		->get()->records->first();
}

public function index($index = 0, $columns = false){

		if($columns === false || count($columns) <= 0){
			$this->setColumns($this->model->getFillable());
		}else{
			$this->setColumns($columns);
		}

		foreach($this->table AS $table){
			$details = [];
			$table->moveTo($index);
			$record=$table->getRecord();

    	foreach($this->columns AS $att){

        	if( in_array($att, $this->children) ){
        		$fn = "get" . ucfirst(strtolower($att)) . "Connection";
                $details[$att] = $this->model->$fn($record);

        	}else{
        		if($att == "SYNOPSIS"){
        			$obj = $record->getColumns()[4];
					$details[$att] = $record->getMemo($obj);

				}else{
					$details[$att] = $record->getObjectByName($att);
				}
        		
        	}

    	}
	   	$details["INDEX"] = $table->getRecordPos();
	   	$this->addDataRecord($details);
	   }

	   	if(count($this->data->records) >= 1){
			return $this->data->records->first();
	   	}
	   	return $this->data->records;
	}

    public function importAndEmpty(){
		
		if($this->parameters->import !== false){
			$result = $this->model->insert($this->data->records);
			$this->truncateRecords();
		}

		return $this;
	}

	public function setData(){
		$startIndex = -1;	
		$resetCounterAt = 500;
		$limit = $this->parameters->perPage * $this->parameters->page;

		foreach($this->table AS $table){

			$allRecords = $table->recordsToArray();
			$counter = 0;
			$total = 0;
			$index = 0; 

			while ($index < count($allRecords) ) {
					
					unset($allRecords[$index]['DELETED']);

					if($this->test($allRecords[$index])){
						$this->addDataRecord($allRecords[$index], false, true, $this->parameters->lists);
						$counter++;
						$total++;		
					}
					
					if($counter === $resetCounterAt) {
						if($this->parameters->import){
							$this->importAndEmpty();
							$counter = 0;
						}
					}else if($total >= $limit){
						break;
					}
					$index++;				
			}
		}

		if($this->parameters->import){
			$this->importAndEmpty();
		}

        return $this;
	}
	public function setData1(){
		ini_set('memory_limit','3000M');
		$startIndex = -1;	
		$resetCounterAt = 500;
		$limit = $this->parameters->perPage * $this->parameters->page;

		foreach($this->table AS $table){

			$table->open();
			$table->moveTo($startIndex);
			$counter = 0;
			$total = 0;

			while ($record1=$table->nextRecord() ) {
					$record = $record1->getRawData($this->model->getIgnoreColumns());
					
					unset($record['DELETED']);

					if($this->test($record)){
						$this->addDataRecord($record, false, true, $this->parameters->lists);
						$counter++;
						$total++;		
					}
					
					if($counter === $resetCounterAt) {
						$this->importAndEmpty();
						$counter = 0;
					}else if($total >= $limit){
						break;
					}				
			}

			$table->close();
		}

		$this->importAndEmpty();

        return $this;
	}

	public function get($loadToArray = false){
		if($loadToArray){
			$this->setData();
		}else{
			$this->setData1();
		}
		$r = new \stdclass;
		$r->paginatorInfo = $this->data->paginator;
		$r->data = $this->data->records;
		return $r;
		
	}

public function first($columns = false){
	$this->setPerPage(1);
	if(count($this->parameters->tests) < 1){
		if($this->parameters->index < 0){$this->parameters->index = 0;}
		return $this->index($this->parameters->index, $columns);
	}else{
		$res = $this->get(true)->data;
		if(isset($res[0])){
			return $res[0];
		}else{
			return null;
		}		
	}
	
}

public function count(){
	return $this->get()->paginator->count;
}

public function getColumns(){


	return $this->table[0]->getColumns();
}

public function flush(){
	$this->data->records = null;
	unset($this->data->records);
	$this->data->records = [];
	return $this;
}

    public function importAll(){
		ini_set('memory_limit','3000M');

		foreach($this->table AS $table){
			$table->importAll();
		}
		
		return true;

    }

}