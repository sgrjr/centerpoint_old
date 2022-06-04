<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdateCartPreferencesMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateCartPreferences'
    ];

    public function type(): Type
    {
        return GraphQL::type('orderhead');
    }

    public function args(): array
    {
        return [
            'token' => ['name' => 'token', 'type' => Type::string()],
            'cartIndex' => ['name' => 'cartIndex', 'type' => Type::int()],
            'REMOTEADDR' => ['name' => 'REMOTEADDR', 'type' => Type::string()],
            "properties" => ['name' => 'properties', 'type' => GraphQL::type('orderheadinput')],
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

      foreach($args['properties'] AS $key=>$val){
          if($key === "ISCOMPLETE"){
              if($val === true){
                $w->$key = "T";
              }else{
                $w->$key = "F";
              }
          }else{
            $w->$key = $val;
          }
        
      }
      $w->saveChanges();
      return $w;
    }
}