<?php namespace App\Models\Traits;

trait DbfTableTrait {

	public function getDbfPrimaryKey(){
		return $this->dbfPrimaryKey;
	}
		
}