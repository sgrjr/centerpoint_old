<?php namespace App\Helpers;

use Illuminate\Support\Arr;

class History
{

public static function ask($args=null){
	$history = new self();
	return $history;
}

public function graphqlArgs($args){
	$this->args = $args;

	if(!isset($this->args["details"])){
		$this->args["details"] = false;
	}
	return $this;
}
protected function build(){	
	$this->records = $this->getAllHistory();
	return $this;
}

	public function get(){		
		$this->build();
		return $this;
	}

	private function getAllHistory(){

		$age = isset($this->args['age'])? explode(",",$this->args['age']) : ["bro", "back", "all","web","ancient"];
		$continue = true;
  		$how_many = isset($this->args["perPage"])? $this->args["perPage"]: 5;
  		$records = [];
		$details = $this->args["details"];

		if($continue && in_array("web", $age)){
			  
			if($details){
				$records[0] = \App\WebDetail::ask()->graphqlArgs($this->args)->get()->records;
			}else{
				$records[0] = \App\WebHead::ask()->graphqlArgs($this->args)->get()->records;
			}

			  $how_many = $how_many - count($records[0]);
	  		if($how_many < 1){$continue = false;}
	  		$this->args["perPage"]= $how_many;
	  	}
	  	
  		if($continue &&  in_array("bro", $age)){

			if($details){
				$records[1] = \App\BroDetail::ask()->graphqlArgs($this->args)->get()->records;
			}else{
				$records[1] = \App\BroHead::ask()->graphqlArgs($this->args)->get()->records;
			}
	  		$how_many = $how_many - count($records[1]);
	  		if($how_many < 1){$continue = false;}
	  		$this->args["perPage"]= $how_many;
	  	}

  		if($continue &&  in_array("back", $age)){
			if($details){
				$records[2] = \App\BackDetail::ask()->graphqlArgs($this->args)->get()->records;
			}else{
				$records[2] = \App\BackHead::ask()->graphqlArgs($this->args)->get()->records;
			}
	  		$how_many = $how_many - count($records[2]);
	  		if($how_many < 1){$continue = false;}
			$this->args["perPage"]= $how_many;
		}

		if($continue &&  in_array("all", $age)){
			  if($details){
				$records[3] = \App\AllDetail::ask()->graphqlArgs($this->args)->get()->records;
			}else{
				$records[3] = \App\AllHead::ask()->graphqlArgs($this->args)->get()->records;
			}
	  		$how_many = $how_many - count($records[3]);
	  		if($how_many < 1){$continue = false;}
	  		$this->args["perPage"]= $how_many;
	  	}

	  	if($continue &&  in_array("ancient", $age)){
			if($details){
				$records[4] = \App\AncientDetail::ask()->graphqlArgs($this->args)->get()->records;
			}else{
				$records[4] = \App\AncientHead::ask()->graphqlArgs($this->args)->get()->records;
			}
  		}

  		return Arr::collapse($records);
	}

	private function getIsbns($collection){
		$list = [];
		foreach($collection AS $co){
			$list[] = $co->ISBN;
		}
		return $list;
	}

}