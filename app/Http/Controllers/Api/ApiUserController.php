<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Core\AuthenticatesUsersTrait AS AuthenticatesUsers;

class ApiUserController extends Controller
{

    use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $args = ["token"=>$request->api_token];
<<<<<<< HEAD
        $viewer = new \App\Helpers\Viewer();
=======
        $viewer = new \App\Viewer();
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
        $processing_carts = new \stdclass;
        $processing_carts->records = [];
        $activeSo  = [];

        if($viewer->user->authenicated){
<<<<<<< HEAD
            $processing_carts = \App\WebHead::ask()
=======
            $processing_carts = \App\Webhead::ask()
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
            ->setPerPage(2000)
            ->where("KEY","===", $user->key )
            ->where("ISCOMPLETE","===", "1" )
            ->get();
            
          $activeSo = $viewer->user->vendor? $data->vendor->activeStandingOrders->records : [];
        }
           
       return response()->json([
            'data' => [
                "user" => $viewer->user,
                "processing_carts" => $processing_carts,
                "activeSo" => $activeSo,
                "carts" => $viewer->user->getCarts(),
                "links" => $viewer->getLinks(),                
                "search"=> "western",
                "titleCategories"=> ["TITLE","ISBN","AUTHOR","LISTPRICE"],
                "searchCategory"=> "title",
                "mainLinks"=> [],
                "processing_count"=> 0,
                "carts_count"=>0,
                "title_lists"=>$viewer->getBrowseProducts()
                ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

}
