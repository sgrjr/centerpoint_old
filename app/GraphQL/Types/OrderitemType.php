<?php
namespace App\GraphQL\Types;

use App\Orderitem;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class OrderitemType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Orderitem',
        'description'   => 'An order item',
        'model'         => OrderItem::class,
    ];

    public function fields(): array
    {
        return [
            'id' => ['type' => Type::nonNull(Type::string()),'description' => 'The id of the user'],
            'TRANSNO' => ['type' => Type::string(),'description' => 'The email of user'],
            'KEY' => ['type' => Type::string(),'description' => 'The name of user'],
            'ISBN' => ['type' => Type::string(),'description' => 'The password of user'],
            'TITLE' => ['type' => Type::string(),'description' => 'The token of user'],
            'AUTHOR' => ['type' => Type::string(),'description' => 'The key of user'],
            'REQUESTED' => ['type' => Type::int(),'description' => 'The key of user'],
            'SALEPRICE' => ['type' => Type::float(),'description' => 'The key of user'],
            'LISTPRICE' => ['type' => Type::float(),'description' => 'The key of user'],
            'SOPLAN' => ['type' => Type::string(),'description' => 'The key of user'],
            'DISC' => ['type' => Type::float(),'description' => 'The key of user'],
            'ORDEREDBY' => ['type' => Type::string(),'description' => 'The key of user']
        ];
    } 
}