<?php
namespace App\GraphQL\Types;

use App\Password;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class AttributeType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Attribute',
        'description'   => 'attributes of vendor',
        'model'         => Password::class,
    ];

    public function fields(): array
    {
        return [

            'auth' => ['type' => Type::listOf(Type::string()),'description' => 'The key of vendor'],
            'password' => ['type' => Type::listOf(GraphQL::type('password')),'description' => 'The email of vendor'],
            'vendor' => ['type' => GraphQL::type('vendor'),'description' => 'The password of vendor'],
            'orders' => [
                'type' => Type::listOf(GraphQL::type('cacheorder')),
                'description' => 'The password of vendor',
                'resolve' => function($root, $args) {
                    return $root["orders"];
                }
            ],
            'standingorders' => ['type' => Type::listOf(GraphQL::type('standingorder')),'description' => 'The password of vendor']
        ];
    } 
}