<?php namespace App\Helpers;

class UserTitleData {

	public function __construct($title, $user){
		$this->title = $title;
		$this->user = $user;

		$this->calcstandingorder();
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
		return in_array($this->title->ISBN, $this->user->getIsbns());
	}

		private function getOnstandingorder(){
			return $this->so->isInList;
		}

		private function calcstandingorder(){
		    $so = new \stdclass;
		    
		    $escape = false;
		    $so->DISC = .25;
		    $so->SALEPRICE = round(round(floatval($this->title->LISTPRICE),2) - ($so->DISC * round(floatval($this->title->LISTPRICE),2)),2);
		    $so->isInList = false;

		    foreach($this->user->vendor->standingOrders AS $standingOrder){

		      if(strtolower($this->title->SOPLAN) === strtolower($standingOrder->SOSERIES) && $standingOrder->QUANTITY > 0){
		        $so = $standingOrder;
		        $so->isInList = true;
		        $escape = true;
		        $so->SALEPRICE = round(round(floatval($this->title->LISTPRICE),2) - ($standingOrder->DISC * round(floatval($this->title->LISTPRICE),2)),2); 
		      }

		      if($escape){
		        break;
		      }
		    }

		    $this->so = $so;
			
		    return $this;

	}

}