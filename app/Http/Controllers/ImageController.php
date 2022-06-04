<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config, Image;
use App\ImageTemplates\MySmall;
use App\Models\ImageModel;

//php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravel5"

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $image = ImageModel::latest()->first();
		$images = ImageModel::all();
        return view('create_image', compact('image','images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$config = Config::get('cp');
		$time = time();

		$this->validate($request, [
            'filename' => 'image|required|mimes:jpeg,png,jpg,gif,svg'
         ]);

		$originalImage = $request->file('filename');
        $thumbnailImage = Image::make($originalImage);
        $originalPath = storage_path() . '/uploads/';

        $thumbnailImage->save(
			$originalPath.
			$time.
			$originalImage->getClientOriginalName()
		);
		$imagemodel = new ImageModel();
        $imagemodel->filename = 'uploads/'.$time.$originalImage->getClientOriginalName();
        $imagemodel->save();


        return back()->with('success', 'Your images has been successfully Upload');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function images($template, $path){

		$this->config = Config::get('cp');
		$this->use_path = null;
		$this->setPath($template, $path);

		$remote = false;
		$test = false;

	if (!file_exists($this->use_path)){
	
		$this->use_path = $this->config["imagesrootpath"] . "/cache/" . $path;

		if(!file_exists($this->use_path)){
			$this->use_path = $this->config["serverimagerootpath"] . DIRECTORY_SEPARATOR . $path;
			$remote = true;
			$test = @get_headers($this->use_path);	
		}

		if (!isset($test) || $test !== true){	
				$this->use_path = $this->config["noimagepath"];
				$remote = true;
		}else if(is_array($test) && $test[0] === 'HTTP/1.1 404 Not Found'){
				$this->use_path = $this->config["noimagepath"];
				$remote = true;
		}
	}

		try {
			
			$img = Image::make($this->use_path);
			if($this->use_path !== $this->config['noimagepath']){
				$img->save( $this->config["imagesrootpath"] . "/cache/" . $path, 50);
			}
		}

		catch(\Throwable $e){
			$img = Image::make($this->config["noimagepath"]);
		}

		try {
			$template = $this->template;
			return $this->$template($img);
		}

		catch(\Throwable $e){
			abort(404,"Cannot find that image!");
		}

    }

	public function setPath($template, $path){
		
		$this->template = $template;
		$this->path = $path;
		$this->extensions = [".jpg",".png",".svg",".jpeg",".bmp",".gif"];

		switch($template){

			case "profile-photo":
				$this->setProfilePhotoPath($template, $path);
				break;

			case "promotions":
				$this->setPromotionsPhotoPath($template, $path);
				break;

			case "slider":
				$this->setSliderPhotoPath($template, $path);
				break;


			default:
				$this->setDefaultPhotoPath($template, $path);
				
		}
	
		return $this;
	}

	public function cache($path){
    	return Image::cache(function($image) use ($path) {
	  		return $image->make($path)->filter(new MySmall);
		}, 10, true);
	}
	
    public function profile($img){
		return $img->filter(new MySmall)
		->fit(100)
		->response();
    }

    public function original($img){
    	return $img->response($img->extension, 100);
    }

    public function slider($img){
    	return $this->original($img);
    }


    public function small($img){
    	return $img->filter(new MySmall)->response($img->extension, 50);
    }

    public function test($img){
    	return $img 
        	->brightness(25)
        	//->grayscale()
        	//->blur()
        	->rotate(45)
        	->ellipse(50, 100, 50, 50, function ($draw) { $draw->border(5, 'fa1c1c');})
        	//->crop(100, 100, 0, 0) // width|height|x|y
        	->resize(300,300) //width|height|callback
        	
        	->response($img->extension, 50)
        	;
	}
	
	private function setProfilePhotoPath($template, $path){
			$imagespathresult = false;
			
			if(file_exists(storage_path() . "/uploads/" . $path)){
				$this->use_path = storage_path() . "/uploads/" . $path;
			}else{
				
				foreach($this->extensions AS $ext){
					if(file_exists(storage_path() . "/uploads/" . $path . $ext)){
						$this->use_path = storage_path() . "/uploads/" . $path . $ext;
						break;
					}
					$this->use_path = $this->config["noimagepath"];
				}
				
			}

			$this->template = "profile";
			return $this;
	}

	private function setPromotionsPhotoPath($template, $path){
		$args = ["id"=>$path];

		$cat = \App\Helpers\Application::catalog($args);
		$this->use_path = $cat->image_path;
		$this->template = $cat->template;
		return $this;
	}

	private function setDefaultPhotoPath($template, $path){
		
		$this->use_path = $this->config["titleimagesrootpath"] . "\\" . $path;
		if(!file_exists($this->use_path)){
			$this->use_path = storage_path() . "\\" .$path;
		}
		$this->template = $template;
		return $this;
	}

	private function setSliderPhotoPath($template, $path){
		$this->use_path = $this->config["imagesrootpath"] . "/slider/" . $path;
		$this->template = $template;
		return $this;
	}
}
