<?php namespace App;

class Passfile extends BaseModel {

	protected $fillable = ["INDEX","KEY","DUNNDAYS","COMPANY","ORGNAME","EMAIL","STANDING","COUNTRY","LISTPRICE","SALEPRICE","WEBSERVER","PASSWORD","DATE","WHATCOLOR","VISION","DISCOUNT"];
	protected $appends = [];
	protected $table = "passfiles";
	//protected $primaryKey = 'REMOTEADDR';
}
