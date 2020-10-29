<?php namespace App;

class Booktext extends BaseModel {

	protected $fillable = [
    "ISTHERE","KEY","SUBJECT","PUBDATE","SYNOPSIS",
    "COMPUTER","DATESTAMP","TIMESTAMP","LASTTOUCH","LASTDATE","LASTTIME","FILENAME",
    "INDEX","CREATED_AT","UPDATED_AT"
];

	protected $appends = [];
	protected $table = "booktexts";
 
	//protected $primaryKey = '';
	protected $dbfPrimaryKey = 'KEY';

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

public function createTable(){
   \Schema::create($this->getTable(), function (\Illuminate\Database\Schema\Blueprint $table) {

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

      $table->integer('INDEX')->unsigned();
      $table->increments('id');
  
      $table->timestamps();
    });
  }

}