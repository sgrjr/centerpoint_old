<?php namespace App;

class Company {
	public function __construct(){
		$this->attributes = \Config::get("cp")["company"];
	}

	public function __get( $property ){
		return $this->attributes[$property];
	}

	public static function first(){
		$n = new self;
		return $n;
	}
}