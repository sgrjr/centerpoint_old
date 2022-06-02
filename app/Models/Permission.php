<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends BaseModel implements \App\Interfaces\ModelInterface
{
    use HasFactory;

    protected $seed = [
        'config_permissions'
    ];

    protected $indexes = [];

    public $timestamps = false;

    protected $attributeTypes = [
        "name"=>[
            "name" => "name",
            "type" => "String",
            "length" => 255
           ],
        "description"=>[
            "name" => "description",
            "type" => "String",
            "length" => 255
           ]
        ];

    public $fillable = ["name","description"];
}
