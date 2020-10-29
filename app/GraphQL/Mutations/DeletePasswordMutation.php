<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class DeletePasswordMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeletePassword'
    ];

    public function type(): Type
    {
        return GraphQL::type('password');
    }

    public function args(): array
    {
        return [
            'token' => ['name' => 'token', 'type' => Type::nonNull(Type::string())],
            'index' => ['name' => 'index', 'type' => Type::nonNull(Type::int())]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        
        $w = \App\Password::dbf()->index($args["index"]);
        
        $passwords = \App\Password::dbf()->where("KEY","==",$w->KEY)->get();
      
        if($passwords->paginator->total >= 2){
            $w->deleteRecord();
            return null;
        }
        
        return $w;
    }
}