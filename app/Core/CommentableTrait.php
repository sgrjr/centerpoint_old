<?php namespace App\Core;

trait CommentableTrait {

	public function comments()
	{
		return $this->morphMany('App\Comment','commentable');
	}
	
}