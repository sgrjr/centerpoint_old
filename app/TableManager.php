<?php namespace App;

class TableManager
{

    protected $fillable = [];
    public $attributes = [];
    public $seed = false;

    public function __construct($table){
        $this->attributes = [
           "id"=>$table->getTable(),
           "source"=> $table->source,
           "name"=> $table->getTable(),
           "memo"=>$table->getMemo(),
           "model"=> get_class($table),
           "updated_at"=> null,
           "created_at"=>null
        ];
    }

    public static function load($table){

        $dbf = null;
        $dbfx = new \App\Dbf;

        if(\Schema::hasTable($dbfx->getTable())) {
          $dbf = $dbfx->where('name',"LIKE", $table->tableSafeName)->first();
        }
        
        if($dbf === null){
          $newthis = new static($table);
          $dbf = \App\Dbf::make($newthis->attributes);
        }

        return $dbf;
    }

}