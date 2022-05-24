<?php namespace App;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Collection;
use Auth, DB, Event, Schema, stdClass;

class Order extends BaseModel
{
	
  protected $fillable = ["KEY","PO_NUMBER", "TRANSNO","DATE","PAIDAMOUNT", "PAIDDATE","BILL_1", "BILL_2", "BILL_3", "BILL_4", "EMAIL","SHIPPING","freeship"];

	protected $table = 'orders';

  public function vendor()
  {
    return $this->belongsTo('\App\User', 'KEY', 'KEY');
  }

  public function items()
  {
    return $this->hasMany('\App\OrderItem', 'TRANSNO', 'TRANSNO');
  }

public function createTable(){
   Schema::create($this->tableSafeName, function (Blueprint $table) {
      $table->increments('id');
      $table->string('KEY')->nullable();
      $table->string('PO_NUMBER')->nullable();
      $table->string('TRANSNO')->nullable();
      $table->string('DATE')->nullable();
      $table->string('BILL_1')->nullable();
      $table->string('BILL_2')->nullable();
      $table->string('BILL_3')->nullable();
      $table->string('BILL_4')->nullable();
      $table->string('EMAIL')->nullable();
      $table->string('PAIDAMOUNT')->nullable();
      $table->string('PAIDDATE')->nullable();
      $table->string('SHIPPING')->nullable();
      $table->string('freeship')->nullable();

     // $table->unsignedInteger('user_id');
      //$table->foreign('user_id')->references('id')->on('users');


    });
  }

    public function beginSeed(){
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      DB::table('order_items')->truncate();
      DB::table('orders')->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1;');

      return $this;
  }

      public function getSeed(){

        $this->seed = [
          //(new \App\Ancienthead)->getDbfPath(),
          (new \App\Allhead)->getDbfPath(),
          (new \App\Backhead)->getDbfPath(),
          (new \App\Brohead)->getDbfPath(),
          (new \App\Webhead)->getDbfPath()
        ];

/*
163,187 Allhead
988 Backhead
718 Brohead
240 Webhead

165,373
*/
        return $this->seed;
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

          default:
            return $record[$att];
        }

        
    }

    public function invoiceVars(){
        return \App\Helpers\Misc::invoiceVars($this);
    }

}