<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CarouselSlideType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Carousel Slide',
        'description'   => 'Config for home page carousel'
    ];

    public function fields(): array
    {
        return [
            'image' => ['type' => Type::string()],
            'caption' => ['type' => Type::string()],
            'link' => ['type' => Type::string()],

        ];
    } 
}