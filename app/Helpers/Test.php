<?php namespace App\Helpers;

ini_set('max_execution_time', 0); // 0 = Unlimited

class Result {
    
    public function __construct($name){
        $this->name = $name;
        $this->result = false;
        $this->text = '';
	}
    public function html(){

    	$html = '<li>' . $this->name;
		$html .= $this->result? "<span style='color:green'>: pass</span>" . $this->text : "<span style='color:red'>: fail" . $this->text . "</span>";
		$html .= '</li>';

     return $html;
	}

    public function setResult($r){
     $this->result = $r;
     return $this;
	}

    public function text($string){
     $this->text .= " - " . $string;
     return $this;
	}
}

class Test 
{
    public function __construct(){
        $this->app = new \stdclass;
        $this->app->config = false;
        $this->logPath = public_path() . '\tests.html';
        $this->tests = [];
        
        $this->models = [
        '\App\AllDetail',
        '\App\AllHead',
        '\App\AncientDetail',
        '\App\AncientHead',
        '\App\BackDetail',
        '\App\BackHead',
        '\App\TitleText',
        '\App\BroHead',
        '\App\BroDetail',
        '\App\Command',
        '\App\Company',
        '\App\Dbf',
        '\App\Inventory',
        '\App\Migration',
        '\App\Order',
        '\App\OrderItem',
        '\App\Passfile',
        '\App\Request',
        '\App\Role',
        '\App\RoleUser',
        '\App\StandingOrder',
        '\App\User',
        '\App\Vendor',
        '\App\WebDetail',
        '\App\WebHead'
     ];

     $this->classes = [
        '\App\Helpers\Compare',
        '\App\Helpers\DatabaseManager',
        '\App\Helpers\History',
        '\App\Helpers\Misc',
        '\App\Helpers\PermissionRequested',
        '\App\Helpers\StringHelper',
        '\App\Helpers\TerminalCommands',
        '\App\Helpers\UserTitleData',
        '\App\Helpers\Viewer',
        '\App\Helpers\ViewerAdmin',
        '\App\Helpers\ViewerAdminModel',
        '\App\Helpers\ViewerAuth',
        '\App\BaseModel',
     ];
      
	}

    private function allClasses(){
        $c = array_merge($this->models, $this->classes);
         return $c;
	}

    public static function log(){
       
       $that = new static;

       if( file_exists( $that->logPath )){
          unlink( $that->logPath );
        }
       $that->doAll();

       return file_get_contents($that->logPath);
	}

    private function doAll(){

     $this
        ->do('configExists','config_exists',[])
        ->do('testAllClasses','can_run_new_up_all_models',['canNewUpClass'])
        ->do('testAllClasses','mysql_can_get_first_of_all_models_and_not_null',['getFirstOfModel','mysql'])
        ->do('testAllClasses','dbf_can_get_first_of_all_models_and_not_null',['getFirstOfModel','dbf'])
        ->do('testAllClasses','ask_can_get_first_of_all_models_and_not_null',['getFirstOfModel','ask'])
        ->do('testAllClasses','can_test_all_models',['canAccessModelAttributes','models'])
        ;

     return $this;
	}

    private function do($func, $name, $props=[]){
        $this->$func($name, $props);
        $this->logAndReset();
        return $this;
	}

    private function logAndReset(){
        $file = $this->logPath;

            $html = "";

	        foreach($this->tests AS $result){
		        $html .= $result->html();
	        }
        // Write the contents to the file, 
        // using the FILE_APPEND flag to append the content to the end of the file
        // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
        file_put_contents($file, $html, FILE_APPEND | LOCK_EX);
        
        
        unset($html);
        unset($this->tests);
        $this->tests = [];
        return $this;
    }

    private function test($name){

        $test = new Result($name);
        $this->tests[$name] = $test;
        return $test;
	}

    private function configExists($name, $props){
        $test = $this->test($name);

        $this->app->config = \Config::get('cp');
        
        if($this->app->config !== false && $this->app->config !== null){
            $test->setResult(true)->text("called config::get(cp)");  
		}

        $this->addTest($test);
        return $this;
	}

    private function canNewUpClass($model, $props){
     $test = $this->test('can_new_up_class_' . $model);

        try{
           $x = new $model;
           unset($x);
           $test->text($model);
           $test->setResult(true);
	   }
       
        catch(\Throwable $e){
            return $this->failed($test,$e);
	    }
        
        $this->addTest($test);
        return $this;
	}

    private function addTest($test){
       $this->tests[$test->name] = $test;
       return $this;
	}

    private function formatException($e){
     return "file: " . $e->getfile() . 
            " -line: " . $e->getLine() . 
            " -code: ". $e->getCode() . 
            " -message: " . $e->getMessage()
            ;
	}

    private function getFirstOfModel($model, $props){
     
     $src = $props[0];
     $test = $this->test($props[0].'_can_get_first_of_model_' . $model);

        try{

            if($src === 'mysql'){
               $x = $model::first();
               $id = $x !== null? $x->primary: null;
               $test->text(" -id: " . $id);
			}else if($src === 'dbf'){
               $x = $model::dbf()->first();
               $test->text(" -mem: " .memory_get_usage() . " -id: " . $x? $x->primary: null);
			}else{
               $x = $model::ask()->first();      
			}
            
           $test->text($model);
           $test->setResult($x !== null);
           unset($x);
	   }
       
        catch(\Throwable $e){
            return $this->failed($test,$e);
	    }
        
        $this->addTest($test);
        return $this;
	}

    private function failed($test,$e){
        $test->text($this->formatException($e));
        $this->addTest($test);
        return $this;
	}

       private function testAllClasses($name, $funcprops){

         $test = $this->test('test_all_classes');
         $func = $funcprops[0];
         $all = isset($funcprops[1])? $funcprops[1]:true;

          \array_splice($funcprops, 0, 1);

        try{
            
            if($all === true){
                $classes = $this->allClasses();
			}else if($all === "models"){
                $classes = $this->models;
			}else{
                $classes = $this->classes;
			}
            //override and send all for now
             $classes = $this->allClasses();
            foreach($classes as $m){
              $this->$func( $m, $funcprops);
			}
           
            $test->setResult(true);

	    }

        catch(\Throwable $e){
            return $this->failed($test,$e);
	    }

        $this->addTest($test);
        $this->logAndReset();
        return $this;
	}

    private function canAccessModelAttributes($model, $props){
     
     $name = 'can_get_attributes_of_model_' . $model;
     $test = $this->test($name);

        try{
            
            $result = $model::ask()->first();

            $test->text($name);

            foreach($result->getAttributes() AS $key=>$val){
                $ans = $model->$key === $val;            
			}
            
           $test->setResult(true);
           
           unset($x);
	   }
       
        catch(\Throwable $e){
            return $this->failed($test,$e);
	    }
        
        $this->addTest($test);
        return $this;
	}
}
