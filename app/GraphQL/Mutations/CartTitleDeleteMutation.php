<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CartTitleDeleteMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CartTitleDelete'
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
            'REMOTEADDR' => ['name' => 'REMOTEADDR', 'type' => Type::string()],
            'ISBN' => ['name' => 'ISBN', 'type' => Type::nonNull(Type::string())]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {

        if(isset($args["cartIndex"])){
            $w = \App\Webhead::dbf()->index($args["cartIndex"]);
        }else{
            $w = \App\Webhead::dbf()
                ->where("REMOTEADDR", "==",$args["REMOTEADDR"])
                ->first();
        }
        
        $w->deleteFromCart($args['ISBN']);

      return new \App\Viewer($args);
    }
}