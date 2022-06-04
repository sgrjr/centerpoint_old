<?php
namespace App\GraphQL\Types;

use App\StandingOrder;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class StandingOrderType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Standing Order',
        'description'   => 'A standing order',
        'model'         => StandingOrder::class,
    ];

    public function fields(): array
    {
        return [
            'INDEX' => ['type' => Type::nonNull(Type::int()),'description' => 'The id of the user'],
            'KEY' => ['type' => Type::string(),'description' => 'The key of user'],
            'SOSERIES' => ['type' => Type::string(),'description' => 'The key of user'],
            'DISC' => ['type' => Type::float(),'description' => 'The key of user'],
            'QUANTITY' => ['type' => Type::int()],
            'EXP_MONTH' => ['type' => Type::string()],
            'EXP_YEAR' => ['type' => Type::string()]
/*
"INDEX","BDUE","BPUR","THEREC","HERE","KEY","QUANTITY","SOSERIES","BILL_1","BILL_2","BILL_3",
"BILL_4","BILL_5","PO_NUMBER","PREPAID","SDATE","EDATE","COMPANY","STREET","DEPT","CITY",
"STATE","POSTCODE","COUNTRY","FREESHIP","SHIPMETHOD","DISC","HANDLING","OTHER","OTHERDESC",
"IOFFER","CXNOTE","CINOTE","TINOTE","DATESTAMP","TIMESTAMP","COMPUTER","LASTDATE","LASTTIME",
"LASTTOUCH","COMMCODE","EMAIL","CANCELDATE","RESTATE","HOTBOX","LASTORDD","NCOMMCODE","OLDCODE",
"INVPREP","","","BADRECORD","PASSBY","PERTIME","PERBOOKS","BOOKS","DAYS","SKIPOVER",
"HIDE","XRANDOM","XHARDONLY","XSOFTONLY","CMONTH","CCONTINUE","TRADTA","VOICEPHONE","CARDKITS","NOCHFIC",
"NOCHROM","NOCHMYS"
            */
        ];
    } 
}