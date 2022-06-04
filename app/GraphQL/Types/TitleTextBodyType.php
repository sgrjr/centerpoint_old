<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TitleTextBodyType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'TitleTextBody',
        'description'   => 'Title related text body'
    ];

    public function fields(): array
    {
        return [
            'type' => [
                'type' => Type::string()
            ],
            'subject' => [
                'type' => Type::string(),
            ],
            'body' => [
                'type' => Type::string(),
            ]
        ];
    } 
}