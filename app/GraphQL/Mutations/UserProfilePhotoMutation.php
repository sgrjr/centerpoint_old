<?php

namespace App\GraphQL\Mutations;

use Closure;
use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class UserProfilePhotoMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateUserProfilePhoto'
    ];

    public function type(): Type
    {
        return GraphQL::type('viewer');
    }

    public function args(): array
    {
        return [
            'profilePicture' => [
                'name' => 'profilePicture',
                'type' => GraphQL::type('Upload'),
                'rules' => ['required', 'image', 'max:1500'],
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $viewer = new \App\Viewer($args);
        $file = $args['profilePicture'];
        $viewer->user->updateProfilePhoto($file);
        return $viewer;
    }
}