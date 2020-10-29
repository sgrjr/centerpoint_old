<?php namespace App\Helpers;

class Compare
{
  public static function is($var1,$c,$var2){

     $meth = [
      '===' => 'equal', 
      '==' => 'equal2', 
      '<' => 'less_than',
      '>' => 'greater_than',
      '>=' => 'greater_than_equal',
      '!==' => 'not_equal',
      '!=' => 'not_equal',
      'LIKE'=>'like',
      'UNLIKE'=>'unlike',
      '=ci' => 'equal_case_insensitive',
      '=or' => 'equal_or',
      '!or' => 'not_equal_or',
      'null' => 'is_null',
      '!null' => 'is_not_null'
    ];

     if($method = $meth[$c]) {
        return static::$method($var1,$var2);
     }
     return null; // or throw excp.
  }
  protected static function equal($op1,$op2){
    return $op1 === $op2;
  }
  protected static function equal2($op1,$op2){
    return $op1 == $op2;
  }

  protected static function equal_case_insensitive($op1,$op2){return strtolower($op1) === strtolower($op2);}

  protected static function equal_or($op1,$op2){
    
    $optional_values = explode(",",$op2);
    $ans = false;

    foreach($optional_values AS $ov){
      if($op1 === $ov){
        $ans = true;
      }
    }
    
    return $ans;
  }

  protected static function not_equal_or($op1,$op2){
    
    $optional_values = explode(",",$op2);
    $ans = true;

    foreach($optional_values AS $ov){
      if($op1 === $ov){
        $ans = false;
      }
    }
    
    return $ans;
  }

  
  protected static function less_than($op1,$op2){return $op1 < $op2;}
  protected static function greater_than($op1,$op2){return $op1 > $op2;}
   protected static function greater_than_equal($op1,$op2){return $op1 >= $op2;}
  protected static function not_equal($op1,$op2){return $op1 !== $op2;}

  protected static function like($op1,$op2){
    
    $op2 = str_replace("%", "", $op2);
    $op2 = str_replace("+", " ", $op2);

    $words = explode(" ", $op2);
    $answer = false;
    
    foreach($words AS $w){
      if (strpos(strtolower($op1), strtolower($w)) !== false) {
        $answer = true;
        break;
      }
    }

    return $answer;

  }

    protected static function unlike($op1,$op2){
    
    $words = explode(" ", $op2);
    $answer = true;
    
    foreach($words AS $w){
      if (strpos(strtolower($op1), strtolower($w)) !== false) {
        $answer = false;
        break;
      }
    }

    return $answer;

  }

  protected static function is_null($op1,$op2){
    return is_null($op1);
  }

  protected static function is_not_null($op1,$op2){
    return !is_null($op1);
  }

  public static function test($record, $parameters){
		$tests = false;
<<<<<<< HEAD

=======
        
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
		if($parameters->tests === "all" ){return true;}
		if(is_array($parameters->tests) && count($parameters->tests) === 0 ){return true;}
		if($parameters->tests === false){return false;}

	    	switch($parameters->testsComparison){

	    		case 'AND':

	    			foreach($parameters->tests AS $s){

	    				if(substr($s[2], 0, 1) === '$'){

	    					try {
	    						$s[2] = $record[str_replace("$", "", $s[2]) ];
	    					}

	    					catch (\Exception $e){
	    						$trace = debug_backtrace();
						        trigger_error(
						            'Undefined property via __get(): ' . $s[2] .
						            ' in ' . $trace[0]['file'] .
						            ' on line ' . $trace[0]['line'],
						            E_USER_NOTICE);
						        return null;
	    					}
						}

						if(Compare::is($record[$s[0]], $s[1], $s[2])){
                            //getting errors that deleted is not set
                            // so disabling this check for now
                            // may never need it if original query to dbf only saves NONDELETED entries
			    			$tests = true;//!$record["DELETED"];
			    			
			    		}else{
			    			$tests = false;
			    			break;
			    		}

			    	}

	    			break;

	    		case 'OR':

	    			foreach($parameters->tests AS $s){

				    		if(Compare::is($record[$s[0]], $s[1], $s[2])){
				    			$tests = true;
				    			break;
				    		}else{
				    			$tests = false;
				    		}

			    	

			    	}

	    			break;
	    	}

		return $tests;
	}

}