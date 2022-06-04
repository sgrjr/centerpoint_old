<?php
namespace App\GraphQL\Types;

use App\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\History;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UserType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'User',
        'description'   => 'A user',
        'model'         => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => ['type' => Type::string(),'description' => 'The id of the user'],
            'email' => ['type' => Type::string(),'description' => 'The email of user'],
            'name' => ['type' => Type::string(),'description' => 'The name of user'],
            'password' => ['type' => Type::string(),'description' => 'The password of user'],
            'token' => ['type' => Type::string(),'description' => 'The token of user'],
            'key' => ['type' => Type::string(),'description' => 'The key of user'],
            'authenticated' => ['type' => Type::boolean(),'description' => 'Auth state of user'],
            'photo' => ['type' => Type::string(),'description' => 'Profile photo of user'],
            'vendor' => [
                'type' => GraphQL::type('vendor'),
                'resolve' => function($root, $args) {
                    return $root->vendor;
                }
            ],
            'credentials' => [
                'type' => GraphQL::type('password'),
                'description' => 'User credentials',
                'resolve' => function($root, $args) {
                    return $root->credentials;
                }
            ],
        ];
    } 
}