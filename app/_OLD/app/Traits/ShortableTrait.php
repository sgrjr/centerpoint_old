<?php namespace App\Traits;

trait ShortableTrait {

	public function shorts()
	{
		return $this->morphMany('App\UrlShort','shortable');
	}
		
}