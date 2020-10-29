<?php namespace App;

use \App\Core\DbfTableTrait;

class TitleText extends BaseModel implements \App\Interfaces\ModelInterface {
    
  use DbfTableTrait;

	protected $fillable = [
    "INDEX","ISTHERE","KEY","SUBJECT","PUBDATE","SYNOPSIS",
    "COMPUTER","DATESTAMP","TIMESTAMP","LASTTOUCH","LASTDATE","LASTTIME","FILENAME"
];

	protected $appends = [];
	protected $table = "booktexts";
   protected $seed = [
    'dbf_booktext'
  ];
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

public function booktextsSchema($table){
      $table->integer('ISTHERE');
      $table->char('KEY');
      $table->string('SUBJECT');
      $table->string('PUBDATE');
      $table->binary('SYNOPSIS');
      $table->string('COMPUTER');
      $table->string('DATESTAMP');
      $table->string('TIMESTAMP');
      $table->string('LASTTOUCH');
      $table->string('LASTDATE');
      $table->string('LASTTIME');
      $table->string('FILENAME');
      $table->timestamps();
      return $table;
  }

}