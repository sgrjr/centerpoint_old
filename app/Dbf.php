<?php namespace App;
use Schema;
use App\DBF\DBaseHandler;
use App\DBF\PHPXbase\XBaseTable;
use App\Helpers\Compare;

class Dbf extends BaseModel {

	protected $fillable = ["id","source","name","memo","model","updated_at","created_at"];
	public $timestamps = true;
	protected $dates = ['created_at', 'updated_at'];
	protected $table = "dbfs";
	protected $appends = ["properties"];
	
	public function createTable(){
		 Schema::create('dbfs',function($table)
			{
				$table->charset = 'utf8';
				$table->collation = 'utf8_unicode_ci';

				$table->increments('id');
				$table->string('name')->unique();
				$table->string('source');
				$table->text('memo');
				$table->string('model');
				$table->timestamps();
			});
	}

}
