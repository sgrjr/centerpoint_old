<?php namespace App\Helpers;

class StringHelper {

	public static function camelCase($str, array $noStrip = [])
	{
			// non-alpha and non-numeric characters become spaces
			$str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
			$str = trim($str);
			$str = strtolower($str);
			// uppercase the first character of each word
			$str = ucwords($str);
			$str = str_replace(" ", "", $str);
			$str = lcfirst($str);

			return $str;
	}

	public static function cleanKey($string){
		$string = str_replace(" ", "", str_replace("-", "_", strtolower($string)));
		return str_replace("&#8217;","",$string);
	}

	public static function dbfPathToModel($path){
		$path = explode("\\", $path);
		$name = $path[count($path)-1];
		$name = strtolower($name);
		$name = str_replace(".dbf","",$name);
		$name = ucfirst($name);
		return "\\App\\Models\\" . $name;
	}

	function convert($size)
	{
	    $unit=array('b','kb','mb','gb','tb','pb');
	    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}

}


  