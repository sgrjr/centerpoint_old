<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CarouselType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Carousel',
        'description'   => 'Config for home page carousel'
    ];

    public function fields(): array
    {
        return [
            'height' => ['type' => Type::string()],
            'background_color' => ['type' => Type::string()],
            'slides' => ['type' => Type::listOf(GraphQL::type("carouselslide"))]
        ];
    } 
}
