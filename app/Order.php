<?php namespace App;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Collection;
use Auth, DB, Event, Schema, stdClass;

class Order extends BaseModel implements \App\Interfaces\ModelInterface
{

  protected $fillable = ["KEY","PO_NUMBER", "TRANSNO","DATE","PAIDAMOUNT", "PAIDDATE","BILL_1", "BILL_2", "BILL_3", "BILL_4", "EMAIL","SHIPPING","freeship"];

	protected $table = 'orders';
<<<<<<< HEAD
  protected $dbfPrimaryKey = 'TRANSNO';
  
  protected $seed = [
    'dbf_ancienthead',
    'dbf_allhead',
    'dbf_brohead',
    'dbf_backhead',
    'dbf_webhead'
  ];
=======
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809

  public function vendor()
  {
    return $this->belongsTo('\App\User', 'KEY', 'KEY');
  }

  public function items()
  {
    return $this->hasMany('\App\OrderItem', 'TRANSNO', 'TRANSNO');
  }

public function schema($table){

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
      $table->foreign('KEY')->references('KEY')->on('users');

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

          default:
            return $record[$att];
        }

        
    }

    public function invoiceVars(){
        return \App\Helpers\Misc::invoiceVars($this);
    }

}