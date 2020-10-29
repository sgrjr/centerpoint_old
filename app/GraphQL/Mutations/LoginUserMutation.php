<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class LoginUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'LoginUser'
    ];

    public function type(): Type
    {
        return GraphQL::type('viewer');
    }

    public function args(): array
    {
        return [
            'email' => ['name' => 'email', 'type' => Type::nonNull(Type::string())],
            'password' => ['name' => 'password', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $viewer = new \App\Viewer($args);

        if($viewer->user->vendor->cartsCount <= 0){
            $newcart = \App\Webhead::newCart($viewer->user->vendor);
        }

        return $viewer;
    }
}