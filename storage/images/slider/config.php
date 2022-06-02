<?php

return [
	
	// Height can be set in any CSS valid height value -- "vh", "px", "%", etc.
	"height" => "40vh",

	//Default Background Color Set Here will be overwritten by IMAGE if it is set or by any direct "style" added to an item
	"background_color"=>"#FFFFFF",

	//Below is the list of Slides. All properties [link, image, caption, caption_class, style] are optional
	// Any Number of Slides May be Created
	"slides" => [

		//#1
		[
			"image"=>"/img/slider/1_image.png",
			"caption"=>"",
		],

		//#2
		[
			"image"=>"/img/slider/2_image.png",
             "link"=>"/isbn/9781643582153",
		],

		//#3
		[
			"image"=>"/img/slider/3_image.png"
		],

		//#4
		[
			"image"=>"/img/slider/4_image.png"
		]
	
	/* EXAMPLES:
		//#1
		["link"=>"http://php.net/manual/en/function.fopen.php", "image"=>"https://www.planetware.com/photos-large/SEY/best-islands-seychelles.jpg","caption"=>"Optional CAPTION and Entire slide is clickable if LINK is set","caption_class"=>"d-flex h-100 align-items-center justify-content-center"],

		//#2
		["link"=>"https://stackoverflow.com/questions/9349469/changing-php-write-permissions-in-xampp-on-windows-7", "image"=>"https://www.planetware.com/photos-large/SEY/best-islands-maldives.jpg"],

		//#3
		["link"=>"https://convertcase.net/", "image"=>"https://www.planetware.com/photos-large/SEY/best-islands-palawan.jpg","caption"=>"Optional CAPTION in LEFT CENTER","caption_class"=>"d-flex h-100 align-items-center"],

		//#4
		["link"=>"https://convertcase.net/", "caption"=>"No Image Necessary with DEFAULT BACKGROUND"],

		//#5
		["caption"=>"No Image Necessary with Custom Style & No Link", "style"=>"background-color:red;"],

		//#6 Blank slide for example only :)
		[],

		//#7 Animation Example
		["caption"=>"Animation Example (SLIDE IN UP)", "caption_class"=>"d-flex h-100 align-items-center animated slideInUp"],      
*/
	]

];

/*

Caption Classes ["caption_class"]
================

CENTER (DEFAULT): d-flex h-100 align-items-center justify-content-center
LEFT CENTER: d-flex h-100 align-items-center

See "https://getbootstrap.com/docs/4.0/components/carousel/" for Bootstrap documention on the carousel
See "https://daneden.github.io/animate.css/" for Animation documentation
*/