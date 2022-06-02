<?php
namespace App\GraphQL;

class GraphQLApp
{   
	public function __construct(){

		$this->classes = ["types"=>[],"query"=>[],"mutation"=>[]];

		$this
		->init("Types","types",app_path() . '/GraphQL/Types', "Type.php")
		->init("Queries","query",app_path() . '/GraphQL/Queries', "Query.php")
		->init("Mutations","mutation",app_path() . '/GraphQL/Mutations', "Mutation.php");
	}

	private function init($class_root, $name, $path, $replace){
		$dir = scandir($path);
		$types = [];

		foreach($dir AS $f){
			if(strpos($f,"php") !== false){
				$n = strtolower(str_replace($replace, "", $f));
				$class_name = '\App\GraphQL\\' . $class_root . "\\" . str_replace(".php", "", $f);
				$this->classes[$name][$n] = $class_name;
			}
		}

		return $this;
	}

	public function getTypes(){
        return $this->classes['types'];
	}

	public function getQuery(){
		return $this->classes['query'];
	}

	public function getMutation(){
		return $this->classes['mutation'];
	}

}