<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class StandingOrdersFiltersInputType extends InputType
{
    protected $attributes = [
        'name' => 'StandingOrdersFiltersInput'
    ];

    public function fields(): array
    {
        return [
            'INDEX' => ['type' => Type::int(),'description' => 'The id of the user'],
            'KEY' => ['type' => Type::string(),'description' => 'The key of user'],
            'SOSERIES' => ['type' => Type::string(),'description' => 'The key of user'],
            'DISC' => ['type' => Type::float(),'description' => 'The key of user'],
            'QUANTITY' => ['type' => Type::string()],
        ];
    }
}