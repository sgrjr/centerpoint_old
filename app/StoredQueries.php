<?php namespace App;

class StoredQueries
{

	//NOTE USED ONLY SHOWN HERE TO SHEW CODING METHOD FOR POSSIBLE FUTURE DEVELOPMENT

     public static function showTitle($input, $isbn, $keep = 300){

     	$cacheKey = 'show_title_page_isbn_'.$isbn;

     	$keep = static::reset($cacheKey, $keep);//skipping cache from now until error can be resolved, "can't serialize"

     	  //return \Cache::remember($cacheKey, $keep, function () use ($input, $isbn){

     	  	$data = new \stdclass;

	    	if( isset($input["index"]) && $input["index"] !== null && $input["index"] !== ""){
	          $data->title = \App\Inventory::ask()->findByIndex($input["index"]);
	        }else{
	          $data->title = \App\Inventory::ask()->find($isbn);
	        }

	        $data->authorTitles = \App\Inventory::ask()
	          ->where("AUTHORKEY","===", $data->title->AUTHORKEY)
	          ->setPerPage(3)
	          ->get();

	          $data->booktext = \App\Booktext::ask()->where("KEY","===",$isbn)->get();
	          return $data;
    //});

   }
           
private static function reset($cacheKey, $keep, $newKeep=300){
	if($keep === "RESET"){\Cache::forget($cacheKey); $keep = $newKeep;}
	return $keep;
}


}        