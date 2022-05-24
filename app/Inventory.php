<?php namespace App;

use App\Webdetail;
use \App\UserTitleData;

class Inventory extends BaseModel {

    protected $primaryKey = 'ISBN';

    protected $fillable = ["INDEX","FASTAVAIL","ISBN","ONHAND","ALLSALES","ONORDER","FASTPRINT","FINALINV","AUTHOR","ARTICLE","TITLE","PUBDATE","STATUS","AUTHPRE","AFIRST","ALAST","SUFFIX","AUTHOR2","AUTHPRE2","AFIRST2","ALAST2","SUFFIX2","PUBSTATUS","CAT","FCAT","SCAT","SGROUP","FORMAT","PAGES","LISTPRICE","SERIES","WHATSERIES","HIGHLIGHT","SOPLAN","RPURCHASES","OPDATE","INVNATURE","PERCARTON","OUNCES","FLATPRICE","ORDERDATE","JOURNALKEY","PRE2016","PAID2016","PRE2017","PAID2017","PRE2018","PAID2018","ADVANCE","LINESALES","UNEARNED","EARNED","CGS","GROSS","WHERE","CATALOG","AUTHORKEY","AFIRSTKEY","AFIRST2KEY","ALASTKEY","ALAST2KEY","TITLEKEY","UNITCOST","RUNITCOST","SUBTITLE","SETRECORD","BISAC1","BISAC2","RIGHTS","SIMO","ROYBOOKS","ROYRETURNS","MARC","COMPUTER","TIMESTAMP","DATESTAMP","PUBLISHER","SHORTITLE","SOLDAT","ONSO","ONBO","SOLD","STITLE","KEY","OPUBDATE","THEBUZZ","PICLOC"
    ];

    protected $appends = [];
    protected $table = 'inventories';

  public function getImgAttribute(){
    $atts = $this->attributes;
    if(isset($atts["PICLOC"]) && isset($atts["ISBN"]) ){
      return url("/img/large/") . $atts["ISBN"] . ".jpg";
    }else{
      return false;
    }

  }

  public function getSmallImageAttribute(){
    $atts = $this->attributes;
    return url("/img/small/" . $atts["ISBN"] . ".jpg");
  }

  public function getDefaultImageAttribute(){
    return $this->getSmallImageAttribute();
  }

  public function getCategoryAttribute(){
    $atts = $this->attributes;
    if(isset($atts["CAT"]) ){
      return $atts["CAT"];
    }else{
      return false;
    }

  }

  public function getImageAttribute(){ if(!isset($this->attributes["ISBN"])){return null;}
    $atts = $this->attributes; return $this->getImgAttribute($atts);}
  public function getIsbnAttribute(){
    
    if(!isset($this->attributes["ISBN"])){return "ISBN";}
    return $this->attributes["ISBN"];
  }
  public function getUrlAttribute(){
     if(!isset($this->attributes["ISBN"])){return null;}
    return "/isbn/" . $this->attributes["ISBN"];}
  public function getListpriceAttribute(){ if(!isset($this->attributes["LISTPRICE"])){return null;}
    return $this->attributes["LISTPRICE"];}
  public function getAuthorAttribute(){ if(!isset($this->attributes["AUTHOR"])){return null;}
    return $this->attributes["AUTHOR"];}
  public function getStatusAttribute(){ if(!isset($this->attributes["STATUS"])){return null;}
    return $this->attributes["STATUS"];}
  public function getFastavailAttribute(){ if(!isset($this->attributes["FASTAVAIL"])){return null;}
    return $this->attributes["FASTAVAIL"];}
  public function getOnhandAttribute(){ if(!isset($this->attributes["ONHAND"])){return null;}
    return $this->attributes["ONHAND"];}
  public function getPublisherAttribute(){ if(!isset($this->attributes["PUBLISHER"])){return null;}
    return $this->attributes["PUBLISHER"];}
  public function getPubdateAttribute(){ if(!isset($this->attributes["PUBDATE"])){return null;}
    return $this->attributes["PUBDATE"];}
  public function getInvnatureAttribute(){ if(!isset($this->attributes["INVNATURE"])){return null;}
    return $this->attributes["INVNATURE"];}
  public function getPagesAttribute(){ if(!isset($this->attributes["PAGES"])){return null;}
    return $this->attributes["PAGES"];}
  public function getFormatAttribute(){ if(!isset($this->attributes["FORMAT"])){return null;}
    return $this->attributes["FORMAT"];}
  public function getCatAttribute(){ if(!isset($this->attributes["CAT"])){return null;}
    return $this->attributes["CAT"];}
  public function getMarcAttribute(){ if(!isset($this->attributes["MARC"])){return null;}
    return $this->attributes["MARC"];}

  public function referenceStandingOrderList($vendorKey, $list=false){
    return \App\Helpers\Misc::referenceStandingOrderList($vendorKey, $this, $list);
  }

   public function getText()
    {
      return \App\Booktext::ask()->where("KEY","===",$this->ISBN);
    }

    public function getTextAttribute(){
        $text = new \App\Booktext();
        if($text->tableExists){
            return $this->hasMany('App\Booktext',"KEY","ISBN")->get();
		}else{
            return $this->getText()->get()->records;
		}
	}

   public function getUserData($viewer)
    {
    	return new UserTitleData($this, $viewer);
    }

    
    public static function getIndexes(){
        return ["AUTHORKEY","CAT"];
	}

}