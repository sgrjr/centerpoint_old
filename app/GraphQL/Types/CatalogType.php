<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CatalogType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'Catalog',
        'description'   => 'Company Catalog'
    ];

    public function fields(): array
    {
        return [
            'image_link' => ['type' => Type::string()],
            'image_path' => ['type' => Type::string()],
            'pdf_link' => ['type' => Type::string()],
            'pdf_path' => ['type' => Type::string()],
            'year' => ['type' => Type::int()],
            'month' => ['type' => Type::string()],
            'template' => ['type' => Type::string()],
            'file_ext' => ['type' => Type::string()]
        ];
    } 
}
