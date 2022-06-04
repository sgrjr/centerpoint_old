<?php

namespace App\Image\Templates;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class MySmall implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image
        	//->encode($image->extension, 50)
        	//->brightness(25)
        	//->grayscale()
        	//->blur(25)
        	//->ellipse(50, 100, 50, 50, function ($draw) { $draw->border(5, 'fff');})
        	//->crop(100, 100, 0, 0) // width|height|x|y
            //->resize(150,230) //width|height|callback
        	;
    }
}