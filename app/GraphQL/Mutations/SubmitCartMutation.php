<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class SubmitCartMutation extends Mutation
{
    protected $attributes = [
        'name' => 'SubmitCart'
    ];

    public function type(): Type
    {
        return GraphQL::type('orderhead');
    }

    public function args(): array
    {
        return [
            'token' => ['name' => 'token', 'type' => Type::nonNull(Type::string())],
            'cartIndex' => ['name' => 'cartIndex', 'type' => Type::int()],
            'REMOTEADDR' => ['name' => 'REMOTEADDR', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        
        if(isset($args["cartIndex"])){
            $w = \App\Models\Webhead::dbf()->index($args["cartIndex"]);
        }else{
            $w = \App\Models\Webhead::dbf()
                ->where("REMOTEADDR", "===",$args["REMOTEADDR"])
                //->where("KEY", "===",$user->KEY)
                ->first();
        }

        $w->submitOrder($args['properties']);

      return $w;
    }
}