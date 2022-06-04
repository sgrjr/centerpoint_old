<?php namespace App\DBF;

use App\Helpers\DbfConverter;

class ViewerInput {

  public $att;

  function __construct($email = null, $password = null, $token = null){
      $this->att = new \stdClass();
       $this->att->email = $email; 
       $this->att->password = $password; 
       $this->att->token = $token; 
   }

  public  $email, $password, $token;

       public function __toString()
       {
         $input = new \stdclass;

           return json_encode($this->att);
       }

}

