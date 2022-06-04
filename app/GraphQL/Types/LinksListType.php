<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class LinksListType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'LinksList',
        'description'   => 'Links for app ui'
    ];

    public function fields(): array
    {
        return [
            'main' => [
                'type' => Type::listOf(GraphQL::type('link')),
                'resolve' => function($root, $args) {
                    return $root->main;
                }
            ],
            'drawer' => [
                'type' => Type::listOf(GraphQL::type('link')),
                'resolve' => function($root, $args) {
                    return $root->drawer;
                }
            ]
        ];
    } 
}