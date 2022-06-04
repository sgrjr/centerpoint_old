<?php
namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Viewer;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use App\History;

class ViewerType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Viewer',
        'description'   => 'A viewer',
        //'model'         => Viewer::class,
    ];

    public function fields(): array
    {
        return [
             /* RELATIONS */
            'user' => [
                'type' => GraphQL::type('user'),
                'description' => 'The user that is viewing app',
                'resolve' => function($root, $args) {
                    return $root->user;
                }
            ],
            'admin' => [
                'type' => GraphQL::type('admin'),
                'description' => 'Admin protected queries',
                'resolve' => function($root, $args) {
                    return $root->admin;
                }
            ],
            'csrftoken' => [
                'type' => Type::string(),
                'resolve' => function($root, $args) {
                    return $root->csrftoken;
                }
            ],

            'titles' => [
                'type' => Type::listOf(GraphQL::type('title')),
                'description' => 'Inventory Titles',
                'args' => [
                    "perPage" => Type::int(),
                    "page" => Type::int(),
                    "filters" => GraphQL::type('titlesfiltersinput'),
                    "first" => Type::boolean()
                ],
                'resolve' => function($root, $args) {
                    $titles = \App\Inventory::ask()
                        ->graphqlArgs($args)
                        ->orderBy('PUBDATE','DESC')
                        ->get();

                    if($titles->paginator->count < $titles->paginator->perPage){
                       
                       if(isset($args["filters"]["INVNATURE"])){
                            if($args["filters"]["INVNATURE"] === "CENTE"){
                              $args["filters"]["INVNATURE"] = "TRADE";                 
							}else{
                                $args["filters"]["INVNATURE"] = "CENTE";
							}
					   }

                       $titles2 = \App\Inventory::ask()
                        ->graphqlArgs($args)
                        ->orderBy('PUBDATE','DESC')
                        ->get();

                        $titles = $titles->records->concat($titles2->records);
					}else{
                        $titles = $titles->records;           
					}

                    return $titles;
                }
            ],

            
            'title' => [
                'type' => GraphQL::type('title'),
                'description' => 'Inventory Title',
                'args' => [
                    "filters" => GraphQL::type('titlesfiltersinput')
                ],
                'resolve' => function($root, $args) {
                   return  \App\Inventory::ask()
                        ->where('ISBN','===', $args['filters']['ISBN'])
                        ->first();
                }
            ],

            'titlelists' => [
                'type' => GraphQL::type('titlelists'),
                'description' => 'Inventory Title Lists',
                'resolve' => function($root) {
                   return $root;
                }
            ],

            'slider' => [
                'type' => GraphQL::type('carousel'),
                'description' => 'A list of vendors',
                'args' => [
                    "perPage" => Type::int()
                ],
                'resolve' => function($root, $args) {   
                    return $root->slider;   
                }
            ],

            'searchfilters' => [
                'type' => Type::listOf(Type::string()),
                'resolve' => function($root, $args) { 
                    return $root->searchfilters;
                }
            ],

            'links' => [
                'type' => GraphQL::type('linkslist'),
                'resolve' => function($root, $args) {
               
                    return $root->links;
                }
            ],

            'browse' => [
                'type' => Type::listOf(GraphQL::type('browse')),
                'resolve' => function($root, $args) {
               
                    return $root->browse;
                }
            ],


            'catalog' => [
                'type' => GraphQL::type('catalog'),
                'description' => 'Company Catalog',
                'args' => [
                    "id" => Type::string()
                ],
                'resolve' => function($root, $args) {   
                    return $root->catalog($args);   
                }
            ],
        ];
    }

} 