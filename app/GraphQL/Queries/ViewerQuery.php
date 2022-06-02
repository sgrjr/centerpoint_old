<?php

namespace App\GraphQL\Queries;

use Closure;
use App\Viewer;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class ViewerQuery extends Query
{
    protected $attributes = [
        'name' => 'Viewer'
    ];

    public function type(): Type
    {
        return GraphQL::type('viewer');
    }

    public function args(): array
    {
        return [
            'token' => ['name' => 'token', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()],
            'password' => ['name' => 'password', 'type' => Type::string()],
            'preload' => ['name' => 'preload', 'type' => Type::ListOf(Type::string())],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    { 
        return new Viewer($args);
    }
}