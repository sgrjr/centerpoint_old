<?php namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class HistoryType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'History',
        'description'   => 'History of vendor orders'
    ];

//->where("ISCOMPLETE","!or", "TRUE,T,true")
    
    public function fields(): array
    {
        return [
            'brohead' => ['type' => Type::listOf(GraphQL::type('orderhead'))],
            'carts' => ['type' => Type::listOf(GraphQL::type('orderhead'))],
            'webhead' => ['type' => Type::listOf(GraphQL::type('orderhead'))],
            'ancienthead' => [ 'type' => Type::listOf(GraphQL::type('orderhead'))],
            'allhead' => ['type' => Type::listOf(GraphQL::type('orderhead'))],
            'backhead' => ['type' => Type::listOf(GraphQL::type('orderhead'))]
        ];
    } 
}