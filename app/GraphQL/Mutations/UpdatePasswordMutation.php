<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class UpdatePasswordMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdatePassword'
    ];

    public function type(): Type
    {
        return GraphQL::type('password');
    }

    public function args(): array
    {
        return [
            'token' => ['name' => 'token', 'type' => Type::nonNull(Type::string())],
            'index' => ['name' => 'index', 'type' => Type::int()],
            "properties" => ['name' => 'properties', 'type' => GraphQL::type('passwordinput')],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $w = \App\Password::dbf()->index($args["index"]);

      foreach($args['properties'] AS $key=>$val){

        if($key === "UPASS"){
            $mPass = \App\Models\User::where("email",$w->EMAIL)->where("password",$w->UPASS)->first();
            if($mPass !== null) {
                $mPass->setPassword($val);
                $mPass->save();
            }
        }else if($key === "EMAIL"){
            $mPass = \App\Models\User::where("email",$w->EMAIL)->where("password",$w->UPASS)->first();
            if($mPass !== null) {
                $mPass->email = $val;
                $mPass->save();
            }
        }
        $w->$key = $val;
      }
      
        $w->dbfSave();
        $w->save();
      return $w;
    }
}