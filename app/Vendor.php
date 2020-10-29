<?php namespace App;
use \App\Core\DbfTableTrait;
class Vendor extends BaseModel implements \App\Interfaces\ModelInterface {

    use DbfTableTrait;
    
	protected $fillable = ["INDEX","KEY","SEX","FIRST","MIDNAME","LAST","TITLE","ARTICLE","ORGNAME","SECONDARY","STREET","CARTICLE","CITY","STATE","ZIP5","COUNTRY","VOICEPHONE","COMMCODE","NEWCODE","EXTENSION","FAXPHONE","EMAIL","WEBSERVER","NATURE","WHAT","PROMOTIONS","BUDGET","RECALLD","ORGNAMEKEY","CITYKEY","COMPUTER","ENTRYDATE","DATESTAMP","TIMESTAMP","LASTTOUCH","LASTDATE","LASTTIME","NOEMAILS","EMCHANGE","REMOVED","REMDATE"];
<<<<<<< HEAD

    private $VENDOR_CACHE_MINUTES = 15;
	protected $table = "vendors";

	protected $dbfPrimaryKey = 'KEY';
    protected $casts = [
        'KEY' => 'string',
    ];
      protected $seed = [
    'dbf_vendor'
  ];

      protected $attributeTypes = [ 
        "_config"=>"vendor",
      ];

      protected $appends = ['summary'];

=======
    private $VENDOR_CACHE_MINUTES = 15;
	protected $table = "vendors";
	protected $appends = [];
	protected $primaryKey = 'KEY';
    protected $casts = [
        'KEY' => 'string',
    ];
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
	public function standingOrders()
    {
        return $this->hasMany('App\StandingOrder','KEY','KEY');
    }
	
	public function orders()
    {
        return $this->hasMany('App\Order','KEY','KEY');
    }

	public function orderHead()
    {
        return $this->hasMany('App\BroHead','KEY','KEY');
    }
	public function getOrderItemsAttribute()
    {
        
        $od = new \App\OrderItem();

        if(!$od->tableExists || $od->count() <= 0){
                $od->seedTable();
		}
            
        //return \Cache::remember('vendor_titles_' . $this->KEY, $this->VENDOR_CACHE_MINUTES, function () {
            return $this->hasMany('App\OrderItem','KEY','KEY')->get();
        //});
    }

    public function calcWholeSaleDisount(){
	  //wholesale discount

	  $passfile = \App\Passfile::ask()->where('KEY',"===",$this->present()->KEY)->first();

	  if($passfile !== null){
	    return $passfile->discount;
	  }else{
	    return false;
	  }

	}

	 public function getStandingOrdersConnection($test = false){
    	$result = \App\StandingOrder::ask()->setPerPage(9999);

        if($test !== false){
            foreach($test AS $t){
                $result->where($t[0],$t[1],$t[2]); 
            }
            
        }
        return $result->where("KEY","==", $this->present()->KEY)->get();
    }

    public function getActiveStandingOrdersAttribute(){
        $test = [
            ["QUANTITY",">","0"]
        ];
       return \Cache::remember('vendor_active_standing_orders_' . $this->KEY, $this->VENDOR_CACHE_MINUTES, function () use ($test){
            return $this->getStandingOrdersConnection($test);
        });
<<<<<<< HEAD
    }

    public function getInactiveStandingOrdersAttribute(){
        $test = [
            ["QUANTITY","<","1"]
        ];
       return \Cache::remember('vendor_inactive_standing_orders_' . $this->KEY, $this->VENDOR_CACHE_MINUTES, function () use ($test){
            return $this->getStandingOrdersConnection($test);
        });
    }

	 public function getUsersAttribute(){
        return \App\Password::ask()->where("KEY","===", $this->KEY)->get();        
=======
    }

    public function getInactiveStandingOrdersAttribute(){
        $test = [
            ["QUANTITY","<","1"]
        ];
       return \Cache::remember('vendor_inactive_standing_orders_' . $this->KEY, $this->VENDOR_CACHE_MINUTES, function () use ($test){
            return $this->getStandingOrdersConnection($test);
        });
    }

	 public function getCredentialsConnection(){

    	$creds = \App\Password::ask()->where("KEY","==", $this->KEY)->get();
        return $creds;
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
    }

    public function getCartsAttribute(){
        $args["filters"]["KEY"] = $this->KEY;
        $args["filters"]["ISCOMPLETE"] = false;
        $args["age"] = "web";
        $args['perPage'] = 1000;
<<<<<<< HEAD
        return \App\WebHead::ask()->graphqlArgs($args)->get()->records;
=======
        return \App\Webhead::ask()->graphqlArgs($args)->get()->records;
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
      }

    public function getCartsCountAttribute(){

        return \Cache::remember('vendor_carts_count_' . $this->KEY, $this->VENDOR_CACHE_MINUTES, function () {
            $args["filters"]["KEY"] = $this->KEY;
            $args["filters"]["ISCOMPLETE"] = false;
            $args["age"] = "web";
            $args['perPage'] = 1000;
<<<<<<< HEAD

            $result = \App\WebHead::ask()->graphqlArgs($args)->get()->records;

            if($result === null){
                return 0;
            }

            return count($result);
=======
            return count(\App\Webhead::ask()->graphqlArgs($args)->get()->records);
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
        });
      }

      public function getProcessingCountAttribute(){

        return \Cache::remember('vendor_processing_carts_count_' . $this->KEY, $this->VENDOR_CACHE_MINUTES, function () {
            $args["filters"]["KEY"] = $this->KEY;
            $args["filters"]["ISCOMPLETE"] = true;
            $args["age"] = "web";
            $args['perPage'] = 1000;
<<<<<<< HEAD

            $result = \App\WebHead::ask()->graphqlArgs($args)->get()->records;

            if($result === null){
                return 0;
            }

             return count($result);


=======
             return count(\App\Webhead::ask()->graphqlArgs($args)->get()->records);
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
        });
      }

      public function getProcessingAttribute(){
        $args["filters"]["KEY"] = $this->KEY;
        $args["filters"]["ISCOMPLETE"] = true;
        $args["age"] = "web";
        $args['perPage'] = 1000;
<<<<<<< HEAD
         return \App\WebHead::ask()->graphqlArgs($args)->get()->records;
      }

         public function getSummaryAttribute(){

            return [
                "carts_count" => $this->cartsCount,
                "processing_count" => $this->processingCount 

            ];

          }

      	public function vendorSchema($table){
		    //$table->index('KEY'); //find out why there are duplicate keys so i can change this to unique('KEY'). right now is getting error on insert due to duplicates.
		    return $table;
	    }

=======
         return \App\Webhead::ask()->graphqlArgs($args)->get()->records;
      }
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
}
