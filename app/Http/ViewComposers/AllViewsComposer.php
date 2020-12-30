<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class AllViewsComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(\App\User $users)
    {
        // Dependencies automatically resolved by service container...
       

        //$this->user = (new \App\Helpers\Viewer())->user;
        /*
        $processing_carts =  \App\WebHead::ask()
                ->setPerPage(1000)
                ->where("KEY","===", \App\User::getViewer()->key )
                ->where("ISCOMPLETE","===", "1" )
                ->count();
      
        $open_carts = \App\WebHead::ask()
                    ->setPerPage(1000)
                  ->where("KEY","===", \App\User::getViewer()->key )
                  ->where("ISCOMPLETE","!=", "1" )
                  ->count();

        if($processing_carts < 1){
            $processing_carts = null;
        }

        if($open_carts <= 1){
            $open_carts = null;
        }

        $this->processing_count = $processing_carts;
        $this->carts_count = $open_carts;
        */
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
      /*  $view
            ->with('processing_count', $this->processing_count)
            ->with('carts_count', $this->carts_count)
            ->with('user', $this->user)
            ->with('api_token', )
            ->with('titleCategories', ["TITLE","ISBN","AUTHOR","LISTPRICE"]);
            */


            //$view
            //->with('processing_count', null)
            //->with('carts_count', null)
            //->with('user', $this->user)
            //->with('api_token', $this->user->api_token)
            //->with('titleCategories', ["TITLE","ISBN","AUTHOR","LISTPRICE"]);
    
    }
}