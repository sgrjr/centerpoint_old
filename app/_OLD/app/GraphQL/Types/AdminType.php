<?php
namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Viewer;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\History;

class AdminType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Admin',
        'description'   => 'A admin',
        'model'         => \App\ViewerAdmin::class,
    ];

    public function fields(): array
    {
        $modelargs = [
            "perPage" => Type::int(),
            "page" => Type::int(),
            "filters" => GraphQL::type('adminfiltersinput'),
            "list" => Type::string()
        ];

        return [

            'allhead' => [
                'type' => Type::listOf(GraphQL::type('orderhead')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->allhead->args($args)->get();
                }
            ],
            'alldetail' => [
                'type' => Type::listOf(GraphQL::type('orderdetail')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->alldetail->args($args)->get();
                }
            ],
            'ancienthead' => [
                'type' => Type::listOf(GraphQL::type('orderhead')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->ancienthead->args($args)->get();
                }
            ],
            'ancientdetail' => [
                'type' => Type::listOf(GraphQL::type('orderdetail')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->ancientdetail->args($args)->get();
                }
            ],
            'backhead' => [
                'type' => Type::listOf(GraphQL::type('orderhead')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->backhead->args($args)->get();
                }
            ],
            'backdetail' => [
                'type' => Type::listOf(GraphQL::type('orderdetail')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->backdetail->args($args)->get();
                }
            ],
            'booktext' => [
                'type' => Type::listOf(GraphQL::type('titletext')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->booktext->args($args)->get();
                }
            ],
            'brohead' => [
                'type' => Type::listOf(GraphQL::type('orderhead')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->brohead->args($args)->get();
                }
            ],
            'brodetail' => [
                'type' => Type::listOf(GraphQL::type('orderdetail')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->brodetail->args($args)->get();
                }
            ],
            'inventory' => [
                'type' => Type::listOf(GraphQL::type('title')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->inventory->args($args)->get();
                }
            ],
            'standingorder' => [
                'type' => Type::listOf(GraphQL::type('standingorder')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->standingorder->args($args)->get();
                }
            ],
            'password' => [
                'type' => Type::listOf(GraphQL::type('password')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->password->args($args)->get();
                }
            ],
            'vendor' => [
                'type' => Type::listOf(GraphQL::type('vendor')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->vendor->args($args)->get();
                }
            ],
            'webhead' => [
                'type' => Type::listOf(GraphQL::type('orderhead')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->webhead->args($args)->get();
                }
            ],
            'webdetail' => [
                'type' => Type::listOf(GraphQL::type('orderdetail')),
                'args' => $modelargs,
                'resolve' => function($root, $args) {
                    return $root->webdetail->args($args)->get();
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
                    return $root->history->args($args)->get();
                }
            ]

        ];
    }

} 