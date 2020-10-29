<?php namespace App\Ask;

use App\Ask\DatabaseType\PHPXbase\XBaseTable;
use App\Ask\DatabaseType\Config\ConfigTable;
use App\Ask\DatabaseType\PHPXbase\XBaseWritableTable as WritableTable;
use App\Ask\DatabaseType\PHPXbase\XBaseTable as Table;
use App\RecordDetails;
use Config;
use App\Ask\AskInterface\AskQueryBuilderInterface;

use App\Ask\QueryBuilder;

class XbaseQueryBuilder extends QueryBuilder implements AskQueryBuilderInterface {
<<<<<<< HEAD
=======
	
	public function source(){
        return 'dbf';
    }

public function setTable(){

   	if(is_array($this->model->getSeed())){
   		$seeds = $this->model->getSeed();
   	}else{
   		$seeds = [$this->model->getDbfPath()];
   	}
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

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
<<<<<<< HEAD
		     
=======
		     //$table->open();
		     $this->table[] = $table;
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
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
<<<<<<< HEAD
		
		if($this->parameters->import !== false && $this->data->records->count() > 0){
			$result = \DB::table($this->parameters->import)->insert($this->data->records->toArray());

			if($this->parameters->perPage >= 8000){
				$this->truncateRecords();
			}
		}
		
=======

		if($this->parameters->import !== false){

				$result = \DB::table($this->parameters->import)->insert($this->data->records->toArray());

				if($this->parameters->perPage >= 8000){
					$this->truncateRecords();
				}
		}

>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
		return $this;
	}


	public function setData($columns = false){
		
		$this->autoSetColumns($columns);
		$total = 0;
		$lastIndex = -1;
	
		$limit = $this->parameters->perPage*$this->parameters->page;		
		$incrementFunction = "nextRecord";

		$limit = $this->parameters->perPage*$this->parameters->page;		
		$incrementFunction = "nextRecord";

		foreach($this->table AS $table){
<<<<<<< HEAD
			$table->open();
=======
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
				//reversing search from last to first
				$veryLastIndex = $table->recordCount - 1;

				if(!$this->parameters->index){
<<<<<<< HEAD
					if($this->parameters->order->direction === "ASC"){
=======
					if($this->parameters->order->direction === "asc"){
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
						$this->setIndex(-1);						
					}else{
						$this->setIndex($table->recordCount+1);
						$incrementFunction = "previousRecord";
					}
				}
				$table->moveTo($this->parameters->index);
		
				$counter = 0;

				if($this->columns !== false && count($this->columns) > 0 ){
<<<<<<< HEAD

				while ($record1=$table->$incrementFunction() ) {

							//Need to implete a way to pass TRUE/FALSE in getRawData(bool)
							//in order to retrive memo fields
							// default behavior is to skip fields
							
							$record = $record1->getRawData(); 
							//temporarily disable for minimal function to avoid memory timeout
							//$record = $record1->getRawDataNoModification();

					    	$lastIndex = $record["INDEX"];

					    	if($tests = $this->test($record) && !$record1->isDeleted()){

					    		$x = [];
					            	foreach($this->columns AS $att){

					                	if(in_array($att, $this->children ) ){
					                		$fn = "get" . ucfirst(strtolower($att)) . "Connection";
						                    $x[$att] = $this->model->$fn($record);
					                	}else{
					                		$x[$att] = $this->getAltColumn($record, $att);
					                	}
					            	}

=======

				while ($record1=$table->$incrementFunction() ) {
							$record = $record1->getRawData();

					    	$lastIndex = $record["INDEX"];

					    	if($tests = $this->test($record) && !$record1->isDeleted()){

					    		$x = [];
					            	foreach($this->columns AS $att){

					                	if(in_array($att, $this->children ) ){
					                		$fn = "get" . ucfirst(strtolower($att)) . "Connection";
						                    $x[$att] = $this->model->$fn($record);
					                	}else{
					                		$x[$att] = $this->model->getAltColumn($record, $att);
					                	}
					            	}

>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
								if(!$record["DELETED"]){

									$this->addDataRecord($x, false, $this->parameters->skipModel, $this->parameters->lists);
									$counter++;
					   			}
								
								if($counter === 500){
									$this->importAndEmpty();
									$counter = 0;
								}

								//file_put_contents("test.js", $counter . "---" . json_encode($record)."\n",FILE_APPEND);
<<<<<<< HEAD
								
								//if($counter > $limit || $record['INDEX'] === $veryLastIndex){
							
								if($counter > $limit){
									break;
								}else{
									if($this->parameters->order->direction === 'DESC' && $record['INDEX'] === 0){
										break;
									}else if($this->parameters->order->direction === 'ASC' && $record['INDEX'] === $table->recordCount-1){
										break;
									}									
=======

								//if($counter > $limit || $record['INDEX'] === $veryLastIndex){
								if($counter > $limit || $record['INDEX'] === 0){
									break;
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
								}
						
			    	}
			      }


			}
			$table->close();
		}
		$this->importAndEmpty();
		$this->data->records = $this->data->records->slice(-$this->parameters->perPage);

		$this->updatePaginator($table->recordCount, $lastIndex);

<<<<<<< HEAD
		$this->importAndEmpty();

		$this->data->records = $this->data->records->slice(-$this->parameters->perPage);

		$this->updatePaginator($table->recordCount, $lastIndex);

=======
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
        return $this;
	}

	public function get($columns = false){
		$this->setData($columns);
		return $this->data;
	}

public function first($columns = false){
	$this->setPerPage(1);
	if(count($this->parameters->tests) < 1){
		if($this->parameters->index < 0){$this->parameters->index = 0;}
		return $this->index($this->parameters->index, $columns);
	}else{
		return $this->get($columns)->records->first();
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

<<<<<<< HEAD
  public function getAltColumn($record, $att){

        if(isset($record[$att]) ){
            return $record[$att];
        }else{
            return null;
        }
    }

=======
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
}