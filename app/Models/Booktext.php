<?php namespace App\Models;

use \App\Traits\DbfTableTrait;

class Booktext extends BaseModel implements \App\Interfaces\ModelInterface {
    
  use DbfTableTrait;

	protected $appends = [];
	protected $table = "booktexts";
   protected $seed = [
    'dbf_booktext'
  ];
  protected $indexes = ["KEY"];
	protected $dbfPrimaryKey = 'INDEX';

      protected $attributeTypes = [
        
        "_config"=>"booktext",

       "created_at"=>[
            "name" => "created_at",
            "type" => "TIMESTAMP",
            "length" => 19
           ],
       "updated_at"=>[
            "name" => "updated_at",
            "type" => "TIMESTAMP",
            "length" => 19
       ],
      ];
  
  public function title()
  {
      return $this->belongsTo('App\Models\Inventory','KEY','ISBN');
  }
  

	public function getSummaryAttribute(){
		return $this->attributes["SYNOPSIS"];
	}

public function getBodyAttribute(){
  $x = new \stdclass;

  switch($this->SUBJECT){
          case "@PLCOMMENTA:":
              $x->type = "commenta";
              $x->subject = "About Author";
              break;

          case "@PLBOOKCOPY:":
              $x->type = "bookcopy";
              $x->subject = "Summary";
              break;
          case "@JOBBERTEXT:":
            $x->type = "jobber";
            $x->subject = "Synopsis";
            break;
          case "@PLREVIEWAA:":
            $x->type = "review";
            $x->subject = "Review";
            break;

          default:
              $x->type = "summary";
              $x->subject = $this->SUBJECT;
      }

      $x->body = $this->summary;

      return $x;

}

	public function getObjectByName($name){
		return $this->$name;
	}

}