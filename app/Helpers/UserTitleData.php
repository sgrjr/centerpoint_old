<?php namespace App\Helpers;

use Cache, stdclass;

class UserTitleData {

	public function __construct($title, $user){
		$this->title = $title;
		$this->user = $user;
		$this
			->initStandingOrder()
			->calcstandingorder();
	}

	private function initStandingOrder(){
		$this->so = new stdclass;
		$this->so->DISC = .25;
		$this->so->LISTPRICE = round($this->title->LISTPRICE,2);
		$this->calcSalePrice();
		$this->so->isInList = false;
		return $this;
	}

	 public function __get($propertyName){
	 	$function = "get" . ucfirst($propertyName);
	 	return $this->$function();
	 } 
	private function getIsbn(){
		return $this->title->ISBN;
	}
	private function getPrice(){
		return $this->so->SALEPRICE;
	}
	private function getUser(){
		return $this->user;
	}
	private function getDiscount(){
		return $this->so->DISC;
	}

	private function getPurchased(){
		return in_array($this->title->ISBN, $this->user->vendor->isbns);
	}

	private function calcSalePrice(){
		$this->so->SALEPRICE = round($this->title->LISTPRICE - ($this->so->DISC * $this->title->LISTPRICE),2);
		return $this;
	}

	private function getOnstandingorder(){
		return $this->so->isInList;
	}

	private function calcstandingorder(){
		if($this->title->INVNATURE === "TRADE"){return $this;}
	    foreach($this->user->vendor->standingOrders AS $standingOrder){
	      if($standingOrder->isActive && $standingOrder->discount > $this->so->DISC){
	        $this->so->DISC = $standingOrder->discount;
	        $this->so->isInList = true;
	        $this->calcSalePrice();
	      }
	    }
	    return $this;

	}

}