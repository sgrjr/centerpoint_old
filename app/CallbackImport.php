<?php namespace App;

class CallbackImport{
	public function __construct ($name, callable $callback)
    {
            $this->name = $name;
            $this->callback = $callback;
    }

    public function callback($entries){
    	call_user_func($this->callback, $this->name, $entries);
    }
}

