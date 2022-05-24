<?php namespace App\Pages;

class Data {
	
	public static function get($model, $request){
		return static::$model($request);
	}
	
	public static function brand($request){
		$brand = (object) config('cp.brand');
		return $brand;
	}
	
	public static function page($request){
		$url = $request->getPathInfo();
		$query =  $request->query();
		$page = new \stdclass;
		$page->url = $url;
		
		switch($url){
			case "/";
				$page->title = "Welcome to " . config('cp.brand.name');
				break;
			default:
				$page->title = "Welcome to " . config('cp.brand.name');
		}
		
		return $page;
		
	}
}

class Composer {
	
	 public function __construct($name, $request){
		$this->name = $name;
		$this->request = $request;
 
		$this->loadSections()
			->updateSection('head')
			->updateSection('body')
			->updateSection('bodyend')
			->initHTML()
			->initVars()
			->load();
		
		$this->layout = 'default';
		
	}
		public function loadSections(){
			$this->sections = new \stdclass;
			$this->sections->head = null;
			$this->sections->body = [];
			$this->sections->bodyend = null;
			return $this;
		}
		
		public function initVars(){
			$this->str = '';
			$this->vars = [];
			
			$this->vars = array_merge($this->vars, $this->getVars($this->sections->head), $this->getVars($this->sections->bodyend));

			foreach($this->sections->body AS $body){
				$this->vars = array_merge($this->vars, $this->getVars($body));
			}
			
			return $this;
		}
		
			public function getVars($str){
				$vars = [];
				$pattern = '/\$[a-zA-z0-9_]*\b/';
				preg_match_all($pattern, $str, $matches);
				
				foreach($matches[0] AS $m){
					$name = str_replace("$", "", $m);
					if($name !== "x" && $name !== "xx"){
						$vars[$name] = Data::get($name, $this->request);
					}
				}
				
				return $vars;
			}
		
		public function initHTML(){
			
			$this->html = '<html>\n';
			$this->html .= '<head>\n';
			$this->html .= $this->sections->head;
			$this->html .= '</head>\n';
			$this->html .= '<body>\n';
			
			foreach($this->sections->body AS $b){
				$this->html .= $b;
				$this->html .= '\n';
			}
			
			$this->html .= $this->sections->bodyend;
			$this->html .= '</body>\n';
			$this->html .= '</html>';

			return $this;
			
		}
		
	public function updateSection($sec, $str = false){
		
		if($sec = "body"){
			
			foreach($this->sections->body AS $body){
				if($str === false){
					$this->sections->body[] = file_get_contents(resource_path() . '/views/components/default_'.$sec.'.blade.php');
				}else{
					$this->sections->body[] = $str;
				}
			}
			
		}else{
		
			if($str === false){
				$this->sections->$sec = file_get_contents(resource_path() . '/views/components/default_'.$sec.'.blade.php');
			}else{
				$this->sections->$sec = $str;
			}
		}
		
		return $this;
	}
	
}

class WelcomePage extends Composer {
	public function load(){		
		return $this;
	}
}

class Page
{

    public function __construct($template, $request)
    {
		$this->template = $template;
		$this->request = $request;

		$this->pages = [
			"welcome" => WelcomePage::class
		];
		
		$this->setPage();
    }

	public function render()
    {	
		$fileName = resource_path() . "/views/components/cache/".$this->template . ".blade.php";

		if(!file_exists($fileName)){
			$file = fopen($fileName,"w");
			fwrite($file, $this->page->html);
			fclose($file);
		}

		return view('components.cache.'. $this->template, $this->page->vars);
    }
	
	private function setPage()
    {
		$pageclass = $this->pages[$this->template];
		$this->page = new $pageclass($this->template, $this->request);	
    }
	

	
}
