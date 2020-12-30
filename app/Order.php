<?php namespace App;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Collection;
use Auth, DB, Event, Schema, stdClass;
use \App\Core\DbfTableTrait;

class Order extends BaseModel implements \App\Interfaces\ModelInterface
{

  use DbfTableTrait;

  protected $fillable = ["ATTENTION", "BADRECORD", "BILLWEIGHT", "BILL_1", "BILL_2", "BILL_3", "BILL_4", "BILL_5", "BITEMS", "BPRODUCT", "CANBILL", "CHECKDESC", "CINOTE", "CITY", "COMMCODE", "COMPANY", "COMPUTER", "COUNTRY", "CXNOTE", "DATE", "DATEIN", "DATEOUT", "DATESTAMP", "DEPT", "EMAIL", "F810NUM", "F810SENT", "F855NUM", "F855SENT", "F856NUM", "F856SENT", "F997NUM", "F997SENT", "FAXPHONE", "FREESHIP", "HOLDNOW", "HOTBOX", "INDEX", "INVLMNT", "INVQUERY", "ITEMS", "KEY", "KICKBACK", "LASTDATE", "LASTTIME", "LASTTOUCH", "MASTERDATE", "MASTERPASS", "NEWITEMS", "NEWPRODUCT", "OLDCODE", "ORDEREDBY", "OSETNUM", "OSOURCE", "OSOURCE2", "OSOURCE3", "OSOURCE4", "OTHER", "OTHERDESC", "PACKAGES", "PAID", "PAIDAMOUNT", "PAIDDATE", "PAYTYPE", "PEPACK", "PINVOICE", "PIPACK", "POSTCODE", "PO_NUMBER", "PRODUCT", "PROMONAME", "PSHIP", "REMOTEADDR", "REVDATE", "ROOM", "SALESTAX", "SENDEMCONF", "SHIPLABEL", "SHIPMETHOD", "SHIPPER", "SHIPPING", "SORTORDER", "SPECIALD", "STATE", "STREET", "TAXEXEMPT", "TERMS", "TESTTRAN", "TIMEIN", "TIMEI","TIMEOUT","TIMESTAMP","TITEMS", "TPRODUCT", "TRANSNO", "TRANSNUM", "UPSDATE", "UPS_KEY", "USERPASS", "VISION", "VOICEPHONE"];

	protected $table = 'orders';

  protected $dbfPrimaryKey = 'TRANSNO';
  
  protected $seed = [
    'dbf_ancienthead',
    'dbf_allhead',
    'dbf_brohead',
    'dbf_backhead',
    'dbf_webhead'
  ];

 protected $attributeTypes = [ 
        "CINOTE"=>["name"=>"CINOTE","type"=>"Char","length"=>255]
  ];

  public function vendor()
  {
    return $this->belongsTo('\App\User', 'KEY', 'KEY');
  }

  public function items()
  {
    return $this->hasMany('\App\OrderItem', 'TRANSNO', 'TRANSNO');
  }

public function ordersSchema($table){
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