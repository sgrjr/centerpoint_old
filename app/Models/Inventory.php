<?php namespace App\Models;

use App\Models\WebDetail;
use App\Helpers\UserTitleData;
use App\Traits\DbfTableTrait;
use App\Helpers\Misc;
use Schema;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Inventory extends BaseModel implements \App\Interfaces\ModelInterface{

    use DbfTableTrait;

    protected $dbfPrimaryKey = 'ISBN';
    protected $appends = ['coverArt','marcLink'];
    protected $table = 'inventories';
    protected $indexes = ["ISBN"];
    public $timestamps = false;

    protected $seed = [
      'dbf_inventory'
    ];

  protected $attributeTypes = [ 
        "_config"=>"inventory",
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
    return url("/img/small/" . $this->attributes['ISBN'] . ".jpg");
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
  public function getMarcLinkAttribute(){

    if($this->MARC === "MARC"){
          return [
        "view" => url("http://centerpointlargeprint.com/cp_info/cp_marc/".$this->ISBN.".txt"),
        "download" => url("http://centerpointlargeprint.com/cp_info/cp_marc/".$this->ISBN.".mrc")
      ];
    }
    return null;
  }

  public function referenceStandingOrderList($vendorKey, $list=false){
    return \App\Helpers\Misc::referenceStandingOrderList($vendorKey, $this, $list);
  }


    public function text(){
        return $this->hasMany('App\Models\Booktext',"KEY","ISBN");
	  }

   public function getUserData()
    {

      if(request()->user() !== null){
        $user = new UserTitleData($this, request()->user());

         return (object) [
          "price"=> $user->price,
          "purchased"=>$user->purchased,
          "onstandingorder"=>$user->onstandingorder,
          "discount"=>$user->discount,
          "isbn"=>$user->isbn
        ];
      }else{
        return new \stdclass;
      }
    	
    }

    public function inventoriesSchema($table){
  		$table->string("ALLSALES")->nullable()->change();
      $table->string("ISBN")->unique()->change();
      
        /// write indexes someday to optimize up mysql queries ["AUTHORKEY","CAT"];
  		return $table;
  	}


    public function byAuthor(){
      return $this->hasMany('App\Models\Inventory',"AUTHORKEY","AUTHORKEY");
    }
    public function byCategory(){
      return $this->hasMany('App\Models\Inventory',"CAT","CAT");
    }

    public function byPubdate(){
      return $this->hasMany('App\Models\Inventory',"PUBDATE","PUBDATE");
    }

    public function byInvnature(){
      return $this->hasMany('App\Models\Inventory',"INVNATURE","INVNATURE");
    }

    public function byFormat(){
      return $this->hasMany('App\Models\Inventory',"FORMAT","FORMAT");
    }

    public function bySeries(){
      return $this->hasMany('App\Models\Inventory',"SERIES","SERIES");
    }

    public function bySoplan(){
      return $this->hasMany('App\Models\Inventory',"SOPLAN","SOPLAN");
    }

    public function byPublisher(){
      return $this->hasMany('App\Models\Inventory',"PUBLISHER","PUBLISHER");
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


    public function getMarcs($_, $args){
      $ds = DIRECTORY_SEPARATOR;

      $zip_file_base = $ds . 'marcs'.$ds.'compiled_marc_'.Carbon::now()->timestamp.'.zip';
      $matches = false;
      $zip_file = public_path() . $zip_file_base;

      $zip = new \ZipArchive();
      $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

      $path = \Config::get('cp')['marc_records_path'];
     
      foreach ($args["isbns"] as $isbn)
      {
        if($isbn !== null){
              $filePath = $path .$ds.$isbn.".mrc";
              if(file_exists($filePath)){
                $matches = true;
                $relativePath = $isbn.'.mrc';
                $zip->addFile($filePath, $relativePath); 
              }else{
                $missing_path = public_path() .$ds."marcs".$ds."missing.mrc";

                file_put_contents(storage_path() . $ds."missing_marcs.txt", 'Cannot find MARC record: ' . $filePath . "\n", FILE_APPEND);

                if(file_exists($missing_path)){
                  $relativePath = 'MISSING_'.$isbn.'.txt';
                  $zip->addFile($missing_path, $relativePath); 
                }
              }
            }
      }

      $zip->close();

      return [
        "zip" => $zip_file_base,
        "isbns" => $args["isbns"]
      ];

    }

    public function getSearchSuggestions(){
      return [
        "paginatorInfo"=>["total"=>12, "count"=>12],
        "data"=> \Config::get('cp')["search_suggestions"]
      ];
    }

  public function scopeCustomer(Builder $query): Builder {
    return $query->where('id', ">=", 37);
  }

}