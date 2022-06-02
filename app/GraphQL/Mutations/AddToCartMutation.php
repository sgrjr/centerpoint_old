<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class AddToCartMutation extends Mutation
{
    protected $attributes = [
        'name' => 'AddToCart'
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
            'ISBN' => ['name' => 'ISBN', 'type' => Type::nonNull(Type::string())],
            'QTY' => ['name' => 'QTY', 'type' => Type::nonNull(Type::int())],
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
        $viewer = new \App\Viewer($args);
        
        $w->addToCart($viewer, $args['ISBN'], $args['QTY']);

      return $viewer;
    }
}