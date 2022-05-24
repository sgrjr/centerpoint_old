<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class OrderHeadType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Order Head',
        'description'   => 'Credentials details'
    ];

    public function fields(): array
    {
        return [

            'details' => [
                'type' => Type::listOf(GraphQL::type('orderdetail')),
                'resolve' => function($root, $args) {
                    return $root->getDetailsConnection()->records;
                }
            ],
            'invoice' => [
                'type' => GraphQL::type('invoice'),
                'resolve' => function($root, $args) {
                    if($this->ISCOMPLETE !== "1"){
                        $invoiceTitle = "For Review";
                        return $root->invoiceVars($invoiceTitle);
                    }
                    return $root->invoiceVars();
                }
            ],
            'INDEX' => ['type' => Type::nonNull(Type::string()),'description' => 'The id of the password'],
            'KEY' => ['type' => Type::string()],
            'KICKBACK' => ['type' => Type::string()],
            'INVQUERY' => ['type' => Type::string()],
            'INVLMNT' => ['type' => Type::string()],
            'PROMONAME' => ['type' => Type::string()],
            'MASTERPASS' => ['type' => Type::string()],
            'MASTERDATE' => ['type' => Type::string()],
            'DATE' => ['type' => Type::string()],
            'PO_NUMBER' => ['type' => Type::string()],
            'TRANSNO' => ['type' => Type::string()],
            'BILL_1' => ['type' => Type::string()],
            'BILL_2' => ['type' => Type::string()],
            'BILL_3' => ['type' => Type::string()],
            'BILL_4' => ['type' => Type::string()],
            'BILL_5' => ['type' => Type::string()],
            'TESTTRAN' => ['type' => Type::string()],
            'NEWPRODUCT' => ['type' => Type::string()],
            'TPRODUCT' => ['type' => Type::string()],
            'PRODUCT' => ['type' => Type::string()],
            'SHIPPING' => ['type' => Type::string()],
            'OTHER' => ['type' => Type::string()],
            'SALESTAX' => ['type' => Type::string()],
            'NEWITEMS' => ['type' => Type::string()],
            'ITEMS' => ['type' => Type::string()],
            'TITEMS' => ['type' => Type::string()],
            'USERPASS' => ['type' => Type::string()],
            'OTHERDESC' => ['type' => Type::string()],
            'SHIPMETHOD' => ['type' => Type::string()],
            'freeship' => ['type' => Type::string()],
            'COMPANY' => ['type' => Type::string()],
            'ATTENTION' => ['type' => Type::string()],
            'STREET' => ['type' => Type::string()],
            'ROOM' => ['type' => Type::string()],
            'DEPT' => ['type' => Type::string()],
            'CITY' => ['type' => Type::string()],
            'STATE' => ['type' => Type::string()],
            'POSTCODE' => ['type' => Type::string()],
            'COUNTRY' => ['type' => Type::string()],
            'VOICEPHONE' => ['type' => Type::string()],
            'FAXPHONE' => ['type' => Type::string()],
            'EMAIL' => ['type' => Type::string()],
            'sendemconf' => ['type' => Type::string()],
            'ORDEREDBY' => ['type' => Type::string()],
            'PINVOICE' => ['type' => Type::string()],
            'PEPACK' => ['type' => Type::string()],
            'PIPACK' => ['type' => Type::string()],
            'PSHIP' => ['type' => Type::string()],
            'COMPUTER' => ['type' => Type::string()],
            'TIMESTAMP' => ['type' => Type::string()],
            'DATESTAMP' => ['type' => Type::string()],
            'UPS_KEY' => ['type' => Type::string()],
            'BILLWEIGHT' => ['type' => Type::string()],
            'OSOURCE' => ['type' => Type::string()],
            'OSOURCE2' => ['type' => Type::string()],
            'paid' => ['type' => Type::string()],
            'PAIDAMOUNT' => ['type' => Type::string()],
            'PAIDDATE' => ['type' => Type::string()],
            'CHECKDESC' => ['type' => Type::string()],
            'PAYTYPE' => ['type' => Type::string()],
            'ONSLIP' => ['type' => Type::string()],
            'REMOTEADDR' => ['type' => Type::string()],
            'LASTTOUCH' => ['type' => Type::string()],
            'LASTDATE' => ['type' => Type::string()],
            'LASTTIME' => ['type' => Type::string()],
            'REVDATE' => ['type' => Type::string()],
            'UPSDATE' => ['type' => Type::string()],
            'PACKAGES' => ['type' => Type::string()],
            'COMMCODE' => ['type' => Type::string()],
            'OLDCODE' => ['type' => Type::string()],
            'TERMS' => ['type' => Type::string()],
            'OSOURCE3' => ['type' => Type::string()],
            'OSOURCE4' => ['type' => Type::string()],
            'SPECIALD' => ['type' => Type::string()],
            'taxexempt' => ['type' => Type::string()],
            'canbill' => ['type' => Type::string()],
            'DATEIN' => ['type' => Type::string()],
            'TIMEIN' => ['type' => Type::string()],
            'TIMEOUT' => ['type' => Type::string()],
            'SHIPPER' => ['type' => Type::string()],
            'SORTORDER' => ['type' => Type::string()],
            'CXNOTE' => ['type' => Type::string()],
            'CINOTE' => ['type' => Type::string()],
            'DATEOUT' => ['type' => Type::string()],
            'HOTBOX' => ['type' => Type::string()],
            'ICOLLNOTE' => ['type' => Type::string()],
            'TRANSNUM' => ['type' => Type::string()],
            'F997SENT' => ['type' => Type::string()],
            'F997NUM' => ['type' => Type::string()],
            'F855SENT' => ['type' => Type::string()],
            'F855NUM' => ['type' => Type::string()],
            'F856SENT' => ['type' => Type::string()],
            'F856NUM' => ['type' => Type::string()],
            'F810SENT' => ['type' => Type::string()],
            'F810NUM' => ['type' => Type::string()],
            'SHIPLABEL' => ['type' => Type::string()],
            'OSETNUM' => ['type' => Type::string()],
            'AREVEIW' => ['type' => Type::string()],
            'ISCOMPLETE' => ['type' => Type::boolean()]
        ];
    } 
}