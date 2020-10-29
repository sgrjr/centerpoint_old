<?php namespace App;

use App\Inventory;
use stdclass;
use App\User;
use Auth;

class Data {
	
	public $data;

	public function __construct(){
		$this->data = [];
	}

	public function json(){
		return json_encode($this->data);
	}

	public function __set($prop, $val){
		$this->data[$prop] = $val;
	}

	public function __get($prop){
		return $this->data[$prop];
	}

}

class RouteModel {

	public static function data($url){

		$data = new Data();

		switch ($url){

			case '/':
				$inv = new Inventory;
				$data->cp = $inv->getCPTitles();
				$data->trade = $inv->getTradeTitles();
				$data->advanced = $inv->getAdvancedTitles();
				break;

			case '/random':
				$r = rand(0,1000);
				$data->user = User::dbf()->where("INDEX",">=",$r)->first();
				break;

			case '/user':
				$data->user = Auth::user();
			default:
				//
		}

		return $data;
	}


	public static function userLogin($email, $password){
		$data = new Data();
		$data->user = User::dbf()->where('EMAIL',"===",$email)->where('UPASS',"===",$password)->first();

		return $data;
	}
}