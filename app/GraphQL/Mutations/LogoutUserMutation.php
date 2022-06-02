<?php

namespace App\GraphQL\Mutations;

use Auth, Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class LogoutUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'LogoutUser'
    ];

    public function type(): Type
    {
        return GraphQL::type('viewer');
    }

    public function args(): array
    {
        return [];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        Auth::logout();
        return new \App\Models\Viewer($args);
    }
}