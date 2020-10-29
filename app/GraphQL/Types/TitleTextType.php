<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TitleTextType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'TitleText',
        'description'   => 'Text related to a title from inventory'
    ];

    public function fields(): array
    {
        return [
            'INDEX' => ['type' => Type::string(),'description' => 'The index of the title text'],
            'KEY' => ['type' => Type::string()],
            'ISTHERE' => ['type' => Type::string()],
            'SUBJECT' => ['type' => Type::string()],
            'PUBDATE' => ['type' => Type::string()],
            'SYNOPSIS' => ['type' => Type::string()],
            'COMPUTER' => ['type' => Type::string()],
            'DATESTAMP' => ['type' => Type::string()],
            'TIMESTAMP' => ['type' => Type::string()],
            'FILENAME' => ['type' => Type::string()],
            'LASTTOUCH' => ['type' => Type::string()],
            'LASTDATE' => ['type' => Type::string()],
            'LASTTIME' => ['type' => Type::string()],
            'body' => ['type' => GraphQL::type('titletextbody')]
  
        ];
    } 
}