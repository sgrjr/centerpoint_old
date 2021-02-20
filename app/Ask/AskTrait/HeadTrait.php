<?php namespace App\Ask\AskTrait;

trait HeadTrait {

	public function getDetailsUrlAttribute(){
		return $this->urlroot . $this->attributes[$this->getDbfPrimaryKey()];
	}

	public function getTotalAttribute(){

    if($this->items === null){
      return 0 * 1.00;
    }
    
		$total = 0;

		foreach($this->items AS $item){
			$total = $total + $item->costAsNumber;
		}

		return $total * 1.00;
	}

	public function getKeyAttribute(){ return $this->attributes["KEY"];}
	public function getRemoteaddrAttribute(){
		if(isset($this->attributes["REMOTEADDR"])){
			return $this->attributes["REMOTEADDR"];
		}
		return null;
	}
	public function getDateAttribute(){return $this->attributes["DATE"];}

	public function getInvoiceDatesAttribute(){
	  $invoiceDates = [];

	  if($this->attributes["PO_NUMBER"] !== "" && $this->attributes["PO_NUMBER"] !== null){
        $invoiceDates[] = "PO#: " . $this->attributes["PO_NUMBER"];
      }

      $invoiceDates[] = "Date: " . $this->attributes["DATE"];
      $invoiceDates[] = "TIMESTAMP: " . $this->attributes["TIMESTAMP"];
      $invoiceDates[] = "DATESTAMP: " . $this->attributes["DATESTAMP"];

      return $invoiceDates;
	}

	public function getInvoiceAttribute(){
		return $this->invoiceVars();
	}
    public function invoiceVars(){

    	$invoiceTitle="Invoice";
    	$thanks=false;
    	$invoiceMemo=false;
    	$footerMemo=false;

		switch(get_class($this)){

			case 'App\Webhead':

				if($this->ISCOMPLETE){
					$invoiceTitle="Processing";
				}else{
					$invoiceTitle="For Review";
				}
				break;

			case 'App\Backhead':
				$invoiceTitle="Back Ordered";
				break;
			default:
				$invoiceTitle="Invoice";
		}

		$thanks = $thanks? $thanks:"Thank You!";
		$invoiceMemo = $invoiceMemo? $invoiceMemo:"<u>Memo</u>: <b>Invoice memo notes</b>";
		$footerMemo = $footerMemo? $footerMemo:"footer memo";
		$bodyHeadings = ["ISBN","TITLE","REQUESTED", "SALEPRICE"];
		
		$invoiceDates = [];
  
		if($this->PO_NUMBER !== "" && $this->PO_NUMBER !== null){
		  $invoiceDates[] = "PO#: " . $this->po_number;
		}
  
		$totaling = $this->cartTotaling();
		$company = \App\Company::first();
  
	  return[
			"id" => $this->TRANSNO, //string
			"title"=> $invoiceTitle, //string
			"dates" => $invoiceDates, // array of strings in the "DATES" section of invoice, i.e. ~["PO#: $ponumber","Shipped: 11/1/2019"]~
			"headings"=>$bodyHeadings, //Array of strings for the column heading of each column in body, i.e,. ["ISBN","TITLE","REQUESTED", "SALEPRICE"]
			"totaling"=>$totaling, // Cart Summary Totaling Array, i.e., ["subtotal"=> $400.01, ...]
			"company_logo"=>$company->logo, // image src
			"company_website"=>$company->website, //website url
			"company_name"=>$company->name, 
			"company_address"=>$company->address,
			"company_telephone"=>$company->telephone,
			"company_email"=>$company->email,
			
			"customer_name"=> $this->BILL_1,
			"customer_address"=>$this->BILL_2 . $this->BILL_3 . $this->BILL_4,
			"customer_email"=>$this->EMAIL,
  
			"thanks"=>$thanks,
			"invoice_memo"=>$invoiceMemo,
			"footer_memo"=>$footerMemo
		  ];
	}
  
	public function cartTotaling(){

		  $shipping = $this->SHIPPING? $this->SHIPPING:0;
		  $paid = $this->PAIDAMOUNT? $this->PAIDAMOUNT:0;        
		  $subtotal = 0.00;
  
		  $itemTotals = [];
  
		  foreach($this->items AS $book ){
		  	//file_put_contents('numbers', "\n" . $book->SALEPRICE . "=>" . is_numeric($book->SALEPRICE) . "-" . $book->REQUESTED . "=>" .  is_numeric($book->REQUESTED) , FILE_APPEND);
			$cost = (int) $book->SALEPRICE * (int) $book->REQUESTED;
			//file_put_contents('numbers', " ?? ". $cost . '=>' . is_numeric($cost), FILE_APPEND);

			$subtotal = number_format($subtotal+$cost,2);
			file_put_contents('numbers', "\n" . $subtotal . '=>' . is_numeric($subtotal), FILE_APPEND);
		  }
  
		  if($shipping === null || $shipping === ""){$shipping = "?";}
		  if($paid === null || $paid === ""){$paid = 0.00;}
  			
		  $grandtotal = 0;
  
		  if($shipping !== "?"){
			$grandtotal = number_format(($subtotal+$shipping)-$paid,2);
		  }else{
			$grandtotal = null;
			$shipping = null;
		  }

		  file_put_contents(
		  	'numbers', 
		  	"\n ". $subtotal . '=>' . is_numeric($subtotal) . " | " . 
		  	$shipping . '=>' . is_numeric($shipping) . " | " . 
		  	$paid . '=>' . is_numeric($paid) . " | " . 
		  	$grandtotal . '=>' . is_numeric($grandtotal)
		  	, FILE_APPEND);

		  $totaling = [
			  "subtotal"=> $subtotal, 
			  "shipping"=> $shipping, 
			  "paid"=>$paid, 
			  "grandtotal"=>$grandtotal
		  ];
		  return $totaling;
		}

}
