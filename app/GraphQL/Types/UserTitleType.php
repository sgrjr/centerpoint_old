<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UserTitleType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'UserTitle',
        'description'   => 'User related data of a title'
    ];

    public function fields(): array
    {
        return [
            'isbn' => [
                'type' => Type::string(),
                'resolve' => function($root) {
                    return $root->isbn;
                }
            ],
            'price' => ['type' => Type::float(),
                'resolve' => function($root) {
                    return $root->price;
                }],
            'discount' => ['type' => Type::float(),
                'resolve' => function($root) {
                    return $root->discount;
                }],
            'purchased' => ['type' => Type::boolean(),
                'resolve' => function($root) {
                    return $root->purchased;
                }],
            'onstandingorder' => ['type' => Type::boolean(),
                'resolve' => function($root) {
                    return $root->onstandingorder;
                }]
        ];
    } 
}