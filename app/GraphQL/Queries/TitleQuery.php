<?php

namespace App\GraphQL\Queries;

use Closure;
use App\Inventory;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class TitleQuery extends Query
{
    protected $attributes = [
        'name' => 'Title query'
    ];

    public function type(): Type
    {
        return GraphQL::type('titlelists');
    }

    public function args(): array
    {
        return [
            //'token' => ['name' => 'token', 'type' => Type::string()],
            //'email' => ['name' => 'email', 'type' => Type::string()],
            //'password' => ['name' => 'password', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        return Inventory::class;
    }
}