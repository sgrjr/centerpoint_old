<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\InputType;

class OrderHeadInputType extends InputType
{
    protected $attributes = [
        'name' => 'OrderHeadInput'
    ];

    public function fields(): array
    {
        return [
            'KEY' => ['name' => 'KEY','type' => Type::string()],
            'DATE' => ['name' => 'DATE','type' => Type::string()],
            'BILL_1' => ['name' => 'BILL_1','type' => Type::string()],
            'BILL_2' => ['name' => 'BILL_2','type' => Type::string()],
            'BILL_3' => ['name' => 'BILL_3','type' => Type::string()],
            'BILL_4' => ['name' => 'BILL_4','type' => Type::string()],
            'BILL_5' => ['name' => 'BILL_5','type' => Type::string()],
            'VOICEPHONE' => ['name' => 'VOICEPHONE','type' => Type::string()],
            'FAXPHONE' => ['name' => 'FAXPHONE','type' => Type::string()],
            'EMAIL' => ['name' => 'EMAIL','type' => Type::string()],
            'SENDEMCONF' => ['name' => 'SENDEMCONF','type' => Type::string()],
            'ORDEREDBY' => ['name' => 'ORDEREDBY','type' => Type::string()],
            'OTHER' => ['name' => 'OTHER','type' => Type::string()],
            'PO_NUMBER' => ['name' => 'PO_NUMBER','type' => Type::string()],
            'ISCOMPLETE' => ['name' => 'ISCOMPLETE','type' => Type::boolean()],
            'PAIDAMOUNT' => ['name' => 'PAIDAMOUNT','type' => Type::float()],
            'REMOTEADDR' => ['name' => 'REMOTEADDR','type' => Type::string()],
            'INDEX' => ['name' => 'INDEX','type' => Type::int()],
            'TRANSNO' => ['name' => 'TRANSNO','type' => Type::string()],
            'CINOTE' => ['name' => 'CINOTE','type' => Type::string()],
        ];
    }
}