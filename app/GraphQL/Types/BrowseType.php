<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BrowseType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Browse',
        'description'   => 'Browse links for app ui'
    ];

    public function fields(): array
    {
        return [
            'title' => [
                'type' => Type::string()
            ],
            'items' => [
                'type' => Type::listOf(GraphQL::type('link'))
            ]
        ];
    } 
}