<?php
namespace App\GraphQL\Types;

use App\Password;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PasswordType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Password',
        'description'   => 'Credentials details',
        'model'         => Password::class,
    ];

    public function fields(): array
    {
        return [
            'INDEX' => ['type' => Type::nonNull(Type::string()),'description' => 'The id of the password'],
            'KEY' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'EMAIL' => ['type' => Type::string(),'description' => 'The email of vendor'],
            'UPASS' => ['type' => Type::string(),'description' => 'The password of vendor'],
            'UNAME' => ['type' => Type::string()],
            'SNAME' => ['type' => Type::string()],
            'SEX' => ['type' => Type::string()],
            'FIRST' => ['type' => Type::string()],
            'MIDNAME' => ['type' => Type::string()],
            'LAST' => ['type' => Type::string()],
            'ARTICLE' => ['type' => Type::string()],
            'TITLE' => ['type' => Type::string()],
/*
["","KEY","LOGINS","DATEUPDATE","DATESTAMP","UPASS","MPASS","","","","PIC","COMPANY","","","","","",
"","ORGNAME","STREET","SECONDARY","CITY","CARTICLE","STATE","COUNTRY","POSTCODE","NATURE",
"VOICEPHONE","EXTENSION","FAXPHONE","COMMCODE","MDEPT","MFNAME","TSIGNOFF","TIMESTAMP","TIMEUPDATE",
"CANBILL","TAXEXEMPT","PASSCHANGE","PRINTQUE","SENDEMCONF","SEARCHBY","MULTIBUY","SORTBY","FULLVIEW",
"SKIPBOUGHT","OUTOFPRINT","OPROCESS","OBEST","OADDTL","OVIEW","ORHIST","OINVO","EXTZN","INSOS","INREG",
"LINVO","NOEMAILS","ADVERTISE","PROMOTION","PASSDATE","EMCHANGE"];
*/
        ];
    } 
}