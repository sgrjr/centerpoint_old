<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class LinkType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Link',
        'description'   => 'Link for app ui'
    ];

    public function fields(): array
    {
        return [
            'url' => [
                'type' => Type::string()
            ],
            'text' => [
                'type' => Type::string(),
            ],
            'icon' => [
                'type' => Type::string(),
            ]
        ];
    } 
}