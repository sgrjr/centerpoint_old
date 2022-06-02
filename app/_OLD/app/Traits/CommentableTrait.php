<?php namespace App\Traits;

trait CommentableTrait {

	public function comments()
	{
		return $this->morphMany('App\Comment','commentable');
	}
	
}