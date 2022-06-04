<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TitleTitleType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'TitleTitle',
        'description'   => 'Titles related to a title from inventory'
    ];

    public function fields(): array
    {
        return [
            'samecat' => ['type' => Type::ListOf(GraphQL::type('title'))],
            'sameauthor' => ['type' => Type::ListOf(GraphQL::type('title'))]  
        ];
    } 
}