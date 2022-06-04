<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class AdminFiltersInputType extends InputType
{
    protected $attributes = [
        'name' => 'AdminFiltersInput'
    ];

    public function fields(): array
    {
        return [
            'INDEX' => ['name' => 'INDEX','type' => Type::string()],
            'KEY' => ['name' => 'KEY','type' => Type::string()],
            'SEX' => ['name' => 'SEX','type' => Type::string()],
            'FIRST' => ['name' => 'FIRST','type' => Type::string()],
            'MIDNAME' => ['name' => 'MIDNAME','type' => Type::string()],
            'LAST' => ['name' => 'LAST','type' => Type::string()],
            'TITLE' => ['name' => 'TITLE','type' => Type::string()],
            'ARTICLE' => ['name' => 'ARTICLE','type' => Type::string()],
            'ORGNAME' => ['name' => 'ORGNAME','type' => Type::string()],
            'SECONDARY' => ['name' => 'SECONDARY','type' => Type::string()],
            'STREET' => ['name' => 'STREET','type' => Type::string()],
            'CARTICLE' => ['name' => 'CARTICLE','type' => Type::string()],
            'CITY' => ['name' => 'CITY','type' => Type::string()],
            'STATE' => ['name' => 'STATE','type' => Type::string()],
            'ZIP5' => ['name' => 'ZIP5','type' => Type::string()],
            'COUNTRY' => ['name' => 'COUNTRY','type' => Type::string()],
            'VOICEPHONE' => ['name' => 'VOICEPHONE','type' => Type::string()],
            'COMMCODE' => ['name' => 'COMMCODE','type' => Type::string()],
            'NEWCODE' => ['name' => 'NEWCODE','type' => Type::string()],
            'EXTENSION' => ['name' => 'EXTENSION','type' => Type::string()],
            'FAXPHONE' => ['name' => 'FAXPHONE','type' => Type::string()],
            'EMAIL' => ['name' => 'EMAIL','type' => Type::string()],
            'WEBSERVER' => ['name' => 'WEBSERVER','type' => Type::string()],
            'NATURE' => ['name' => 'NATURE','type' => Type::string()],
            'WHAT' => ['name' => 'WHAT','type' => Type::string()],
            'PROMOTIONS' => ['name' => 'PROMOTIONS','type' => Type::string()],
            'BUDGET' => ['name' => 'BUDGET','type' => Type::string()],
            'RECALLD' => ['name' => 'RECALLD','type' => Type::string()],
            'ORGNAMEKEY' => ['name' => 'ORGNAMEKEY','type' => Type::string()],
            'CITYKEY' => ['name' => 'CITYKEY','type' => Type::string()],
            'COMPUTER' => ['name' => 'COMPUTER','type' => Type::string()],
            'ENTRYDATE' => ['name' => 'ENTRYDATE','type' => Type::string()],
            'DATESTAMP' => ['name' => 'DATESTAMP','type' => Type::string()],
            'TIMESTAMP' => ['name' => 'TIMESTAMP','type' => Type::string()],
            'LASTTOUCH' => ['name' => 'LASTTOUCH','type' => Type::string()],
            'LASTDATE' => ['name' => 'LASTDATE','type' => Type::string()],
            'LASTTIME' => ['name' => 'LASTTIME','type' => Type::string()],
            'NOEMAILS' => ['name' => 'NOEMAILS','type' => Type::boolean()],
            'EMCHANGE' => ['name' => 'EMCHANGE','type' => Type::string()],
            'REMOVED' => ['name' => 'REMOVED','type' => Type::boolean()],
            'REMDATE' => ['name' => 'REMDATE','type' => Type::string()],
            'UNAME' => ['name' => 'UNAME','type' => Type::string()],
            'ISCOMPLETE' => ['name' => 'ISCOMPLETE','type' => Type::boolean()],
            'ISBN' => ['name' => 'ISBN','type' => Type::string()],
            'INVNATURE' => ['name' => 'INVNATURE','type' => Type::string()],
        ];
    }
}