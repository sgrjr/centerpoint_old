<?php namespace App;

use App\WebDetail;
use \App\Helpers\UserTitleData;
use \App\Core\DbfTableTrait;
use App\Helpers\Misc;
use Schema;

class Inventory extends BaseModel implements \App\Interfaces\ModelInterface{


    use DbfTableTrait;

    protected $dbfPrimaryKey = 'ISBN';

    protected $fillable = [
        "INDEX","ISBN","ONHAND","AUTHOR","TITLE","PUBDATE","STATUS","CAT","FCAT","SCAT","FORMAT",
        "PAGES","LISTPRICE","SERIES","SOPLAN","INVNATURE","AUTHORKEY","TITLEKEY","SUBTITLE","MARC",
        "PUBLISHER","HIGHLIGHT","FASTAVAIL","ISBN","ONHAND","ALLSALES","ONORDER","FASTPRINT","FINALINV",
        "AUTHOR","ARTICLE","TITLE","PUBDATE","STATUS","AUTHPRE","AFIRST","ALAST","SUFFIX","AUTHOR2",
        "AUTHPRE2","AFIRST2","ALAST2","SUFFIX2","PUBSTATUS","CAT","FCAT","SCAT","SGROUP","FORMAT",
        "PAGES","LISTPRICE","SERIES","WHATSERIES","SOPLAN","RPURCHASES","OPDATE","INVNATURE",
        "PERCARTON","OUNCES","FLATPRICE","ORDERDATE","JOURNALKEY","PRE2016","PAID2016","PRE2017",
        "PAID2017","PRE2018","PAID2018","ADVANCE","LINESALES","UNEARNED","EARNED","CGS","GROSS",
        "WHERE","CATALOG","AUTHORKEY","AFIRSTKEY","AFIRST2KEY","ALASTKEY","ALAST2KEY","TITLEKEY",
        "UNITCOST","RUNITCOST","SUBTITLE","SETRECORD","BISAC1","BISAC2","RIGHTS","SIMO","ROYBOOKS",
        "ROYRETURNS","MARC","COMPUTER","TIMESTAMP","DATESTAMP","PUBLISHER","SHORTITLE","SOLDAT",
        "ONSO","ONBO","SOLD","STITLE","KEY","OPUBDATE","THEBUZZ","PICLOC"

    ];
   

    protected $appends = ['coverArt'];
    protected $table = 'inventories';

    public $timestamps = false;

    protected $seed = [
      'dbf_inventory'
    ];

  protected $attributeTypes = [ 
  //  "_config"=>"inventory",
        "INDEX"=>["name"=>"INDEX","type"=>"Int","length"=>50],
        "FASTAVAIL"=>["name"=>"FASTAVAIL","type"=>"Char","length"=>3],
        "ISBN"=>["name"=>"ISBN","type"=>"Char","length"=>13],
        "ONHAND"=>["name"=>"ONHAND","type"=>"String","length"=>5],
        "AUTHOR"=>["name"=>"AUTHOR","type"=>"Char","length"=>34],
        "TITLE"=>["name"=>"TITLE","type"=>"Char","length"=>45],
        "PUBDATE"=>["name"=>"PUBDATE","type"=>"Int","length"=>8],
        "STATUS"=>["name"=>"STATUS","type"=>"Char","length"=>20],
        "CAT"=>["name"=>"CAT","type"=>"Char","length"=>26],
        "FCAT"=>["name"=>"FCAT","type"=>"Char","length"=>2],
        "SCAT"=>["name"=>"SCAT","type"=>"Char","length"=>2],
        "FORMAT"=>["name"=>"FORMAT","type"=>"Char","length"=>15],
        "PAGES"=>["name"=>"PAGES","type"=>"Integer","length"=>4],
        "LISTPRICE"=>["name"=>"LISTPRICE","type"=>"Integer","length"=>7],
        "SERIES"=>["name"=>"SERIES","type"=>"Char","length"=>28],
        "SOPLAN"=>["name"=>"SOPLAN","type"=>"Char","length"=>30],
        "INVNATURE"=>["name"=>"INVNATURE","type"=>"Char","length"=>5],
        "AUTHORKEY"=>["name"=>"AUTHORKEY","type"=>"Char","length"=>20],
        "TITLEKEY"=>["name"=>"TITLEKEY","type"=>"Char","length"=>20],
        "SUBTITLE"=>["name"=>"SUBTITLE","type"=>"Char","length"=>100],
        "HIGHLIGHT"=>["name"=>"HIGHLIGHT","type"=>"Char","length"=>100],
        "MARC"=>["name"=>"MARC","type"=>"Char","length"=>4],
        "PUBLISHER"=>["name"=>"PUBLISHER","type"=>"Char","length"=>40]
  ];

  public function getCoverArtAttribute(){
    return url("/img/small/" . $this->ISBN . ".jpg");
  }


  public function getCategoryAttribute(){
    $atts = $this->attributes;

    if(isset($atts["CAT"]) ){
      return $atts["CAT"];

    }else{
      return false;
    }

  }

  public function getImageAttribute(){return $this->getImgAttribute($atts);}
  public function getUrlAttribute(){return url("/isbn/" . $this->ISBN);}

  public function referenceStandingOrderList($vendorKey, $list=false){
    return \App\Helpers\Misc::referenceStandingOrderList($vendorKey, $this, $list);
  }

    public function text(){
        return $this->hasMany('App\Booktext',"KEY","ISBN");
	  }

   public function getUserData($user)
    {
    	return new UserTitleData($this, $user);
    }

    public function inventoriesSchema($table){
  		$table->string("ALLSALES")->nullable()->change();
      $table->string("ISBN")->unique()->change();
      
        /// write indexes someday to optimize up mysql queries ["AUTHORKEY","CAT"];
  		return $table;
  	}


    public function byAuthor(){
      return $this->hasMany('App\Inventory',"AUTHORKEY","AUTHORKEY");
    }
    public function byCategory(){
      return $this->hasMany('App\Inventory',"CAT","CAT");
    }

    public function byPubdate(){
      return $this->hasMany('App\Inventory',"PUBDATE","PUBDATE");
    }

    public function byInvnature(){
      return $this->hasMany('App\Inventory',"INVNATURE","INVNATURE");
    }

    public function byFormat(){
      return $this->hasMany('App\Inventory',"FORMAT","FORMAT");
    }

    public function bySeries(){
      return $this->hasMany('App\Inventory',"SERIES","SERIES");
    }

    public function bySoplan(){
      return $this->hasMany('App\Inventory',"SOPLAN","SOPLAN");
    }

    public function byPublisher(){
      return $this->hasMany('App\Inventory',"PUBLISHER","PUBLISHER");
    }

    public function byTitle(){

      $query = \DB::table('inventories');
      
      if($this->TITLE !== null) {
        
        $words = explode(" ", trim($this->TITLE));

        if(count($words) > 1){
          abort(404, json_encode($words));
        }
        $ctr = 0;
        foreach($words AS $w){

          if(trim($w) !== ""){
            if($ctr === 0){
              $query->where('TITLE','like',"%".trim($w)."%");
              $ctr++;
            }else{
              $query->orWhere('TITLE','like',"%".trim($w)."%");
            }
            
          }
          
        }
        
      }else{
        $query->where('id','z1');
      }
      
      return $query->get();
    }

    public function getCPTitles(){
      return Misc::gauranteedBooksCount(15, [Misc::pubdateNow(), Misc::pubdateMonthsPast(3), Misc::pubdateMonthsPast(12), Misc::pubdateYearsPast(5)]);  
    }

    public function getTradeTitles(){  
      return Misc::gauranteedBooksCount(15, [Misc::pubdateMonthsPast(1), Misc:: pubdateMonthsPast(3), Misc::pubdateMonthsPast(6),Misc::pubdateYearsPast(5)], "TRADE"); 
    }

    public function getAdvancedTitles(){  
      return Misc::gauranteedBooksCount(30, [ Misc::pubdateMonthsPast(3), Misc::pubdateMonthsPast(12), Misc::pubdateYearsPast(1), Misc::pubdateYearsPast(5)]);
    }

}