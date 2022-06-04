<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class InvoiceTotalingType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'InvoiceTotaling',
        'description'   => 'Invoice Totaling Values'
    ];

    public function fields(): array
    {
        return [
            'subtotal' => ['type' => Type::float()],
            'shipping' => ['type' => Type::float()],
            'paid' => ['type' => Type::float()],
            'grandtotal' => ['type' => Type::float()]
        ];
    } 
}