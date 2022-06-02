<?php
namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Viewer;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Helpers\Misc;

class TitleListsType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Title Lists',
        'description'   => 'Lists of titles in inventory',
        'model'         => Viewer::class,
    ];

    public function fields(): array
    {
        return [
             /* RELATIONS */

             //Upcoming Titles
             'cp' => [
                'type' => Type::listOf(GraphQL::type('title')),
                'description' => 'Inventory Titles',
                'resolve' => function($root, $args) {                    
                    return Misc::gauranteedBooksCount(15, [Misc:: pubdateNow(), Misc:: pubdateMonthsPast(3), Misc:: pubdateMonthsPast(12), Misc:: pubdateYearsPast(2)]);      
                }
            ],

            'trade' => [
                'type' => Type::listOf(GraphQL::type('title')),
                'description' => 'Inventory Titles',
                'resolve' => function($root, $args) {
                     return Misc::gauranteedBooksCount(15, [Misc:: pubdateMonthsPast(1), Misc:: pubdateMonthsPast(3), Misc:: pubdateMonthsPast(6),Misc:: pubdateYearsPast(2)], "TRADE");      
                }
            ],
            //Most Recent Titles
            'advanced' => [
                'type' => Type::listOf(GraphQL::type('title')),
                'description' => 'Inventory Titles',
                'resolve' => function($root, $args) {
                    return Misc::gauranteedBooksCount(30, [Misc:: pubdateMonthsPast(3), Misc:: pubdateMonthsPast(12),Misc:: pubdateYearsPast(1), Misc:: pubdateYearsPast(2)]);      
                }
            ]

        ];
    }

}
