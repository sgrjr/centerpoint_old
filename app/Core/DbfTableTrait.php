<?php namespace App\Core;

use Schema;

trait DbfTableTrait {

	public function schema($table){
		
		$name = $this->getTable();
		$headers = $this->headers;	

		$overRideToString = ["ALLSALES","ONHAND","ONORDER","TRANSNO"];
		$overRideToNumber = ["PUBDATE"];

				foreach($headers AS $h){
					if(in_array($h["name"], $overRideToString)){
						$table->string($h["name"])->nullable(true);
					}else if(in_array($h["name"], $overRideToNumber)){
						$table->integer($h["name"])->nullable(true);
					}else{

					switch($h["type"]){
						case 'character':
						case 'C':
						case 'G':

							$table
								->string($h["name"], $h["length"])
								->nullable(true)
								->char('utf8')
								->collate('utf8_unicode_ci');
							break;
						case 'number':
						case 'numeric':
						case 'Number':	
						case 'N': //Numeric	
								$table->decimal($h["name"],13)
								->nullable(true)
								->char('utf8')
								->collate('utf8_unicode_ci');	
								break;

						case 'I':		//Integer	
						case "Int":
						case "Integer":
								$table->integer($h["name"], false)
								->nullable(true)
								->char('utf8')
								->collate('utf8_unicode_ci');		
							break;
						case 'memo':
						case 'M':
							$table
								->binary($h["name"])
								->nullable(true)
								->char('utf8')
								->collate('utf8_unicode_ci');
							break;
						default:
							$table
							->string(strtolower($h["name"]), 255)
							->nullable(true)
							->char('utf8')
							->collate('utf8_unicode_ci');
					}
				}
			}
			$callback = $name."Schema";

			if(method_exists($this,$callback)){
				$table = call_user_func([$this, $callback], $table);	
			}

			$table->charset = 'utf8';
			$table->collation = 'utf8_unicode_ci';

			return $table;
		
	}

	public function getDbfPrimaryKey(){
		return $this->dbfPrimaryKey;
	}
		
}