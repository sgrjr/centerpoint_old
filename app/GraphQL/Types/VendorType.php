<?php
namespace App\GraphQL\Types;

use App\Vendor;
use App\History;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class VendorType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Vendor',
        'description'   => 'A vendor',
        'model'         => Vendor::class,
    ];

    public function fields(): array
    {
        return [
            'INDEX' => ['type' => Type::nonNull(Type::int()),'description' => 'The id of the user'],
            'KEY' => ['type' => Type::string(),'description' => 'The key of user'],
            'ORGNAME' => ['type' => Type::string(),'description' => 'The key of user'],
            'REMOVED' => ['type' => Type::boolean(),'description' => 'The key of user'],

            'users' => [
                'type' => Type::listOf(GraphQL::type('password')),
                'description' => 'A list of vendor credentials',
                'args' => [
                    "perPage" => Type::int()
                ],
                'resolve' => function($root, $args) {
                    return $root->getCredentialsConnection()->records;
                }
            ],

            'order' => [
                'type' => Type::listOf(GraphQL::type('orderhead')),
                'args' => [
                    "perPage" => Type::int(),
                    "page" => Type::int(),
                    "filters" => GraphQL::type('orderheadinput'),
                    "age" => Type::string()
                ],
                'resolve' => function($root, $args) {
                    $model = new \App\History;
                    $args["filters"]["KEY"] = $root->KEY;
                    return $model->graphqlAsk($args, false)->get()->records;
                }
            ],

            'carts' => [
                'type' => Type::listOf(GraphQL::type('orderhead')),
                'resolve' => function($root, $args) {
                    return $root->carts;
                }
            ],

            'titles' => [
                'type' => Type::listOf(GraphQL::type('orderitem')),
                'resolve' => function($root, $args) {
                    return $root->titles;
                }
            ],

            'isbns' => [
                'type' => Type::listOf(Type::string()),
                'resolve' => function($root, $args) {
                    return $root->isbns;
                }
            ],

            'processing' => [
                'type' => Type::listOf(GraphQL::type('orderhead')),
                'resolve' => function($root, $args) {
                    return $root->processing;
                }
            ],

            'activeStandingOrders' => [
                'type' => Type::listOf(GraphQL::type('standingorder')),
                'resolve' => function($root, $args) {
                    return $root->activeStandingOrders;
                }
            ],

            'inactiveStandingOrders' => [
                'type' => Type::listOf(GraphQL::type('standingorder')),
                'resolve' => function($root, $args) {
                    return $root->inactiveStandingOrders;
                }
            ],

            'standingorders' => [
                'type' => Type::listOf(GraphQL::type('standingorder')),
                'description' => 'Standing orders of a vendor',
                'args' => [
                    "perPage" => Type::int(),
                    "page" => Type::int(),
                    "filters" => GraphQL::type('standingordersfiltersinput'),

                ],
                'resolve' => function($root, $args) {
                    $args["filters"]["KEY"] = $root->KEY;
                    return \App\StandingOrder::graphqlAsk($args, false)->get()->records;
                }
            ],

            'cartscount' => [
                'type' => Type::int(),
                'resolve' => function($root, $args) {
                    return $root->cartsCount;   
                }
            ],
            'processingcount' => [
                'type' => Type::int(),
                'resolve' => function($root, $args) {
                    return $root->processingCount;
                }
            ],
        ];
    } 
}