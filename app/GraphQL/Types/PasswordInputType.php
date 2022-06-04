<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class PasswordInputType extends InputType
{
    protected $attributes = [
        'name' => 'PasswordInput'
    ];

    public function fields(): array
    {
        return [
            'KEY' => ['name' => 'KEY','type' => Type::string()],
            'UPASS' => ['name' => 'UPASS','type' => Type::string()],
            'EMAIL' => ['name' => 'EMAIL','type' => Type::string()],
            'PIC' => ['name' => 'PIC','type' => Type::string()],
            'SEX' => ['name' => 'SEX','type' => Type::string()],
            'FIRST' => ['name' => 'FIRST','type' => Type::string()],
            'MIDNAME' => ['name' => 'MIDNAME','type' => Type::string()],
            'LAST' => ['name' => 'LAST','type' => Type::string()],
            'ARTICLE' => ['name' => 'ARTICLE','type' => Type::string()],
            'TITLE' => ['name' => 'TITLE','type' => Type::string()],
            'ORGNAME' => ['name' => 'ORGNAME','type' => Type::string()],
            'STREET' => ['name' => 'STREET','type' => Type::string()],
            'CITY' => ['name' => 'CITY','type' => Type::string()],
            'CISTATETY' => ['name' => 'STATE','type' => Type::string()],
            'COUNTRY' => ['name' => 'COUNTRY','type' => Type::string()],
            'POSTCODE' => ['name' => 'POSTCODE','type' => Type::string()],
            'VOICEPHONE' => ['name' => 'VOICEPHONE','type' => Type::string()],
            'EXTENSION' => ['name' => 'EXTENSION','type' => Type::string()],
            'FAXPHONE' => ['name' => 'FAXPHONE','type' => Type::string()]     
        ];
    }
}