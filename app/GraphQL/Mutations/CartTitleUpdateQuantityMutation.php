<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CartTitleUpdateQuantityMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CartTitleUpdateQuantity'
    ];

    public function type(): Type
    {
        return GraphQL::type('viewer');
    }

    public function args(): array
    {
        return [
            'token' => ['name' => 'token', 'type' => Type::string()],
            'REMOTEADDR' => ['name' => 'REMOTEADDR', 'type' => Type::nonNull(Type::string())],
            'ISBN' => ['name' => 'ISBN', 'type' => Type::nonNull(Type::string())],
            'REQUESTED' => ['name' => 'REQUESTED', 'type' => Type::nonNull(Type::int())]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {

        $d = \App\Webdetail::dbf()
            ->where("REMOTEADDR", "==",$args["REMOTEADDR"])
            ->where("PROD_NO","==", $args['ISBN'])
            ->first();
        
        $d->REQUESTED = $args['REQUESTED'];
        $d->saveChanges();

        return new \App\Viewer($args);
    }
}