<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TitleType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Title',
        'description'   => 'A book title from inventory'
    ];

    public function fields(): array
    {
        return [
            'defaultImage' => ['type' => Type::string(),'resolve' => function($root, $args) {return $root->getDefaultImageAttribute();}],
            'INDEX' => ['type' => Type::string(),'description' => 'The index of the title'],
            'ISBN' => ['type' => Type::string(),'description' => 'The id of a title'],
            'FASTAVAIL' => ['type' => Type::string()],
            'ONHAND' => ['type' => Type::int()],
            'ALLSALES' => ['type' => Type::string()],
            'ONORDER' => ['type' => Type::string()],
            'FASTPRINT' => ['type' => Type::string()],
            'FINALINV' => ['type' => Type::string()],
            'AUTHOR' => ['type' => Type::string()],
            'ARTICLE' => ['type' => Type::string()],
            'TITLE' => ['type' => Type::string()],
            'PUBDATE' => ['type' => Type::Int()],
            'STATUS' => ['type' => Type::string()],
            'AUTHPRE' => ['type' => Type::string()],
            'AFIRST' => ['type' => Type::string()],
            'ALAST' => ['type' => Type::string()],
            'SUFFIX' => ['type' => Type::string()],
            'AUTHOR2' => ['type' => Type::string()],
            'AUTHPRE2' => ['type' => Type::string()],
            'AFIRST2' => ['type' => Type::string()],
            'ALAST2' => ['type' => Type::string()],
            'SUFFIX2' => ['type' => Type::string()],
            'PUBSTATUS' => ['type' => Type::string()],
            'CAT' => ['type' => Type::string()],
            'FCAT' => ['type' => Type::string()],
            'SCAT' => ['type' => Type::string()],
            'SGROUP' => ['type' => Type::string()],
            'FORMAT' => ['type' => Type::string()],
            'PAGES' => ['type' => Type::string()],
            'LISTPRICE' => ['type' => Type::float()],
            'SERIES' => ['type' => Type::string()],
            'WHATSERIES' => ['type' => Type::string()],
            'HIGHLIGHT' => ['type' => Type::string()],
            'SOPLAN' => ['type' => Type::string()],
            'RPURCHASES' => ['type' => Type::string()],
            'OPDATE' => ['type' => Type::string()],
            'INVNATURE' => ['type' => Type::string()],
            'PERCARTON' => ['type' => Type::string()],
            'OUNCES' => ['type' => Type::string()],
            'FLATPRICE' => ['type' => Type::string()],
            'ORDERDATE' => ['type' => Type::string()],
            'JOURNALKEY' => ['type' => Type::string()],
            'PRE2016' => ['type' => Type::string()],
            'PAID2016' => ['type' => Type::string()],
            'PRE2017' => ['type' => Type::string()],
            'PAID2017' => ['type' => Type::string()],
            'PRE2018' => ['type' => Type::string()],
            'PAID2018' => ['type' => Type::string()],
            'ADVANCE' => ['type' => Type::string()],
            'LINESALES' => ['type' => Type::string()],
            'UNEARNED' => ['type' => Type::string()],
            'EARNED' => ['type' => Type::string()],
            'CGS' => ['type' => Type::string()],
            'GROSS' => ['type' => Type::string()],
            'WHERE' => ['type' => Type::string()],
            'CATALOG' => ['type' => Type::string()],
            'AUTHORKEY' => ['type' => Type::string()],
            'AFIRSTKEY' => ['type' => Type::string()],
            'AFIRST2KEY' => ['type' => Type::string()],
            'ALASTKEY' => ['type' => Type::string()],
            'ALAST2KEY' => ['type' => Type::string()],
            'TITLEKEY' => ['type' => Type::string()],
            'UNITCOST' => ['type' => Type::string()],
            'RUNITCOST' => ['type' => Type::string()],
            'SUBTITLE' => ['type' => Type::string()],
            'SETRECORD' => ['type' => Type::string()],
            'BISAC1' => ['type' => Type::string()],
            'BISAC2' => ['type' => Type::string()],
            'RIGHTS' => ['type' => Type::string()],
            'SIMO' => ['type' => Type::string()],
            'ROYBOOKS' => ['type' => Type::string()],
            'ROYRETURNS' => ['type' => Type::string()],
            'MARC' => ['type' => Type::string()],
            'COMPUTER' => ['type' => Type::string()],
            'TIMESTAMP' => ['type' => Type::string()],
            'DATESTAMP' => ['type' => Type::string()],
            'PUBLISHER' => ['type' => Type::string()],
            'SHORTITLE' => ['type' => Type::string()],
            'SOLDAT' => ['type' => Type::string()],
            'ONSO' => ['type' => Type::string()],
            'ONBO' => ['type' => Type::string()],
            'SOLD' => ['type' => Type::string()],
            'STITLE' => ['type' => Type::string()],
            'KEY' => ['type' => Type::string()],
            'OPUBDATE' => ['type' => Type::string()],
            'THEBUZZ' => ['type' => Type::string()],
            'PICLOC' => ['type' => Type::string()],

           'titles' => [
                'type' => Type::listOf(GraphQL::type('title')),
                'description' => 'Inventory Titles',
                'args' => [
                    "perPage" => Type::int(),
                    "page" => Type::int(),
                    "filters" => GraphQL::type('titlesfiltersinput'),
                    "key" => Type::string()
                ],
                'resolve' => function($root, $args) {
                    
                    $args["filters"][$args["key"]] = $root->CAT;

                    return $titles = \App\Inventory::ask()
                        ->graphqlArgs($args)
                        ->orderBy('PUBDATE','DESC')
                        ->get()->records;
                }
            ],

            'user' => [
                'type' => GraphQL::type('usertitle'),
                'description' => 'User related data of this title',
                'resolve' => function($root, $args) {
                    $viewer = new \App\Viewer();
                    return $root->getUserData($viewer);                    
                }
            ],

           'text' => [
                'type' => Type::listOf(GraphQL::type('titletext')),
                'description' => 'Title related text and summaries',
                'args' => [],
                'resolve' => function($root, $args, $context) {
                    return $root->text;
                }
            ]

        ];
    } 
}