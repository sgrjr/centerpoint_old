<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class QuestionsType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Questions',
        'description'   => 'Questions and String answers for app'
    ];

    public function fields(): array
    {
        return [

            'hasPurchased' => [
                'type' => Type::string(),
                'args' => ["isbn"=> Type::string()],
                'resolve' => function($root, $args) {
                    return false;
                }
            ],
            
            'discount' => [
                'type' => Type::float(),
                'args' => ["isbn"=> Type::string()],
                'resolve' => function($root, $args) {
                    return .25;
                }
            ],
            
        ];
    } 
}