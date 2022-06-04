<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\InputType;

class QueryInputType extends InputType
{
    public const TYPE = 'QueryInputType';

    protected $attributes = [
        'name' => self::TYPE,
    ];

    public function fields(): array
    {
        return [
            'nullValue' => [
                'type' => Type::int(),
                'alias' => 'null_value',
            ],
            'val' => [
                'type' => Type::int(),
                'alias' => 'val_alias',
            ],
            'defaultValue' => [
                'type' => Type::int(),
                'alias' => 'defaultValue_alias',
                'defaultValue' => 'def',
            ],

            'nest' => [
                'type' => GraphQL::type(ExampleNestedValidationInputObject::TYPE),
            ],
            'list' => [
                'type' => Type::listOf(GraphQL::type(ExampleNestedValidationInputObject::TYPE)),
            ],
        ];
    }
}