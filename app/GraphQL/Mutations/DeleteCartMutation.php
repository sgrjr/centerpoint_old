<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class DeleteCartMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteCart'
    ];

    public function type(): Type
    {
        return GraphQL::type('viewer');
    }

    public function args(): array
    {
        return [
            'token' => ['name' => 'token', 'type' => Type::string()],
            'cartIndex' => ['name' => 'cartIndex', 'type' => Type::int()],
            'REMOTEADDR' => ['name' => 'REMOTEADDR', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        
        if(isset($args["cartIndex"])){
            $w = \App\Webhead::dbf()->index($args["cartIndex"]);
        }else{
            //$user = (new \App\Viewer($args))->user;
            $w = \App\Webhead::dbf()
                ->where("REMOTEADDR", "===",$args["REMOTEADDR"])
                //->where("KEY", "===",$user->KEY)
                ->first();
        }
      
        foreach($w->items AS $item){
            $item->deleteRecord();
          }
      
        $w->deleteRecord();

        $viewer = new \App\Viewer($args);

        if($viewer->user->vendor->cartsCount <= 0){
            $newcart = \App\Webhead::newCart($viewer->user->vendor);
        }

      return $viewer;
    }
}