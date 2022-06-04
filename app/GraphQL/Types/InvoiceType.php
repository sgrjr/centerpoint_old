<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class InvoiceType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Invoice',
        'description'   => 'Invoice variables for a particular order'
    ];

    public function fields(): array
    {
        return [
            
            'id' => ['type' => Type::string()],
            'title' => ['type' => Type::string()],
            'dates' => ['type' => Type::ListOf(Type::string())],
            'headings' => ['type' => Type::ListOf(Type::string())],
            'totaling' => ['type' =>  Graphql::type('invoicetotaling')],
            'company_logo' => ['type' => Type::string()],
            'company_website' => ['type' => Type::string()],
            'company_name' => ['type' => Type::string()],
            'company_address' => ['type' => Type::string()],
            'company_telephone' => ['type' => Type::string()],
            'company_email' => ['type' => Type::string()],
            'customer_name' => ['type' => Type::string()],
            'customer_address' => ['type' => Type::string()],
            'customer_email' => ['type' => Type::string()],
            'thanks' => ['type' => Type::string()],
            'invoice_memo' => ['type' => Type::string()],
            'footer_memo' => ['type' => Type::string()]
        ];
    } 
}