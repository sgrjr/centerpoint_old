<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CacheOrderType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'A Cache of Orders',
        'description'   => 'vendor orders'
    ];

    public function fields(): array
    {
        return [
            'brohead' => ['type' => Type::listOf(GraphQL::type('orderhead')),
                'resolve' => function($root, $args) {
                    if(isset($root["brohead"])){
                        return $root["brohead"];
                    }else{
                        return [];
                    }
                    
                }
            ],
            'webhead' => [
                'type' => Type::listOf(GraphQL::type('orderhead')),
                'resolve' => function($root, $args) {
                    if(isset($root["webhead"])){
                        return $root["webhead"];
                    }else{
                        return [];
                    }
                    
                }
            ],
            'ancienthead' => [
                'type' => Type::listOf(GraphQL::type('orderhead')),
                'resolve' => function($root, $args) {
                    if(isset($root["ancienthead"])){
                        return $root["ancienthead"];
                    }else{
                        return [];
                    }
                    
                }
            ],
            'allhead' => ['type' => Type::listOf(GraphQL::type('orderhead')),
                'resolve' => function($root, $args) {
                    if(isset($root["allhead"])){
                        return $root["allhead"];
                    }else{
                        return [];
                    }
                    
                }],
            'backhead' => ['type' => Type::listOf(GraphQL::type('orderhead')),
                'resolve' => function($root, $args) {
                    if(isset($root["backhead"])){
                        return $root["backhead"];
                    }else{
                        return [];
                    }
                    
                }]
        ];
    } 
}