<?php namespace App;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Collection;
use Auth, Event, Schema, stdClass;

class OrderItem extends BaseModel implements \App\Interfaces\ModelInterface
{
	
  use \App\Ask\AskTrait\DetailTrait;
  
  protected $fillable = ["TRANSNO","KEY","PROD_NO","TITLE", "AUTHOR", "REQUESTED","SALEPRICE","LISTPRICE","SOPLAN","DISC","ORDEREDBY"];
	protected $table = 'order_items';

  
  protected $seed = [
    'dbf_ancientdetail',
    'dbf_alldetail',
    'dbf_brodetail',
    'dbf_backdetail',
    'dbf_webdetail'
  ];

  public function vendor()
  {
    return $this->belongsTo('\App\User', 'KEY', 'KEY');
  }

  public function order()
  {
    return $this->belongsTo('\App\Order', 'TRANSNO', 'TRANSNO');
  }
  

public function schema($table){
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
      $table->foreign('TRANSNO')->references('TRANSNO')->on('orders');
      return $table;
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