<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class OrderDetailType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Order Detail',
        'description'   => 'Vendor Order details'
    ];

    public function fields(): array
    {
        return [
            'defaultImage' => ['type' => Type::string()],
            'url' => ['type' => Type::string()],

            'INDEX' => ['type' => Type::nonNull(Type::string()),'description' => 'The id of the detail'],
            'KEY' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'TRANSNO' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'REQUESTED' => ['type' => Type::int(),'description' => 'The key of vendor'],
            'PROD_NO' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'PUBDATE' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'AUTHOR' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'TITLE' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'INVNATURE' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'SERIES' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'DATE' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'SOPLAN' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'REMOTEADDR' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'ORDEREDBY' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'LISTPRICE' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'SALEPRICE' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'DISC' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'STATUS' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'ISBN10' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'ISBN13' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'STATUS' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'LASTDATE' => ['type' => Type::string(),'description' => 'The key of vendor'],
            'TESTTRAN' => ['type' => Type::string()],
            'ARTICLE' => ['type' => Type::string()],
            'LASTTOUCH' => ['type' => Type::string()],
            'VISION' => ['type' => Type::string()],
            'SHIPPED' => ['type' => Type::string()],
            'ORDERNUM' => ['type' => Type::string()],
            'SUBTITLE' => ['type' => Type::string()],
            'ISSTAND' => ['type' => Type::string()],
            'PUBLISHER' => ['type' => Type::string()],
            'FORMAT' => ['type' => Type::string()],
            'CAT' => ['type' => Type::string()],
            'CATALOG' => ['type' => Type::string()],
            'AUTHORKEY' => ['type' => Type::string()],
            'TITLEKEY' => ['type' => Type::string()],
            'COMPUTER' => ['type' => Type::string()],
            'TIMESTAMP' => ['type' => Type::string()],
            'DATESTAMP' => ['type' => Type::string()],
            'LASTTIME' => ['type' => Type::string()],
            'UNITCOST' => ['type' => Type::string()],
            'PAGES' => ['type' => Type::string()],
            'OUNCES' => ['type' => Type::string()],
            'USERPASS' => ['type' => Type::string()],
            'DROPSHIP' => ['type' => Type::string()],
            'EWHERE' => ['type' => Type::string()],
            'EDI' => ['type' => Type::string()],
            'CARTON' => ['type' => Type::string()],
            'SHIPMENT' => ['type' => Type::string()]
        ];
    } 
}