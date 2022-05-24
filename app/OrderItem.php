<?php namespace App;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Collection;
use Auth, Event, Schema, stdClass;

class OrderItem extends BaseModel
{
	
  use \App\Ask\AskTrait\DetailTrait;
  
  protected $fillable = ["TRANSNO","KEY","PROD_NO","TITLE", "AUTHOR", "REQUESTED","SALEPRICE","LISTPRICE","SOPLAN","DISC","ORDEREDBY"];
	protected $table = 'order_items';

  public function vendor()
  {
    return $this->belongsTo('\App\User', 'key', 'KEY');
  }

  public function order()
  {
    return $this->belongsTo('\App\Order', 'TRANSNO', 'TRANSNO');
  }
  
public function createTable(){
   Schema::create($this->tableSafeName, function (Blueprint $table) {
      $table->increments('id');
      $table->string('TRANSNO')->nullable();
      $table->string('KEY')->nullable();
      $table->string('PROD_NO')->nullable();
      $table->string('TITLE')->nullable();
      $table->string('AUTHOR')->nullable();
      $table->string('SOPLAN')->nullable();
      $table->integer('REQUESTED')->nullable();
      $table->decimal('SALEPRICE',8,2)->nullable();
      $table->decimal('LISTPRICE',8,2)->nullable();
      $table->string('DISC')->nullable();
       $table->string('ORDEREDBY')->nullable();
      //$table->foreign('order_id')->references('id')->on('orders');
    });


    /*
    
    TODO: figure how to add index of "KEY" in this flow.

    ALTER TABLE `centerpoint`.`order_items` ADD INDEX `KEY` (`KEY` ASC);
    
    */
  }

    public function beginSeed(){
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('order_items')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');
      return $this;
  }

    public function getSeed(){

        $this->seed = [
          //(new \App\Ancientdetail)->getDbfPath(),
          (new \App\Alldetail)->getDbfPath(),
          (new \App\Backdetail)->getDbfPath(),
          (new \App\Brodetail)->getDbfPath(),
          (new \App\Webdetail)->getDbfPath()
        ];

        return $this->seed;
    }
  
        public function seedTable(){       
        
            $columns = $this->getFillable();

            $data = \App\Webdetail::dbf()->import("order_items")->all(false, false, $columns)->reset();
		    $data = \App\Brodetail::dbf()->import("order_items")->all(false, false, $columns)->reset();
		    $data = \App\Backdetail::dbf()->import("order_items")->all(false, false, $columns)->reset();
		    $data = \App\Alldetail::dbf()->import("order_items")->all(false, false, $columns)->reset();
      //$data = \App\Ancientdetail::dbf()->import("order_items")->all(false, false, $columns)->reset();
            unset($data);
	  	    return $this;
        }

    public function getAltColumn($record, $att){

        switch($att){

          case 'TRANSNO':

            if($record[$att] === null || $record[$att] === ""){
              return $record['REMOTEADDR'];
            }else{
              return $record[$att];
            }

            break;

          case 'ISBN':

            if(isset($record['PROD_NO'])){
              return $record['PROD_NO'];
            }else if(isset($record[$att])){
              return $record[$att];
            }else{
              return null;
            }

            break;

          default:
            return $record[$att];
        }

        
    }

}