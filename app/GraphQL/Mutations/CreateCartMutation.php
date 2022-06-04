<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use App\Viewer;

class CreateCartMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateCart'
    ];

    public function type(): Type
    {
        return GraphQL::type('viewer');
    }

    public function args(): array
    {
        return [
            'key' => ['name' => 'key', 'type' => Type::string()],
            'token' => ['name' => 'token', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
      $viewer = new Viewer($args);
      $newcart = \App\Webhead::newCart($viewer->user->vendor);
      return $viewer;
    }
}

/*
 
mutation {
  createCart(key:"") {
    COMPANY
    REMOTEADDR
    INDEX
    BILL_1
    BILL_2
    BILL_3
  }
}
 */