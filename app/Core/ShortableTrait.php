<?php namespace App\Core;

trait ShortableTrait {

	public function shorts()
	{
		return $this->morphMany('App\UrlShort','shortable');
	}
		
}