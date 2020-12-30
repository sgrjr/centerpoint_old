<?php namespace App;

class Company extends BaseModel implements \App\Interfaces\ModelInterface{

	protected $dbfPrimaryKey = 'id';

	protected $seed = [
	 'config_company'
	];

	protected $table = 'companies';

    protected $attributeTypes = [
        "name"=>[
            "name" => "name",
            "type" => "Char",
            "length" => 96
           ],
        "email"=>[
            "name" => "email",
            "type" => "Char",
            "length" => 96
           ],
        "telephone"=>[
            "name" => "telephone",
            "type" => "Char",
            "length" => 96
           ],
        "city"=>[
            "name" => "city",
            "type" => "Char",
            "length" => 96
           ],
        "state"=>[
            "name" => "state",
            "type" => "Char",
            "length" => 96
           ],
        "address"=>[
            "name" => "address",
            "type" => "Char",
            "length" => 96
           ],
        "website"=>[
            "name" => "website",
            "type" => "Char",
            "length" => 96
           ],
        "fax"=>[
            "name" => "fax",
            "type" => "Char",
            "length" => 96
           ],
        "logo"=>[
            "name" => "logo",
            "type" => "Char",
            "length" => 96
           ],
       "timestamps"=> true
      ];

protected $fillable = ["name", "email" , "telephone" , "city", "state", "address", "website", "fax", "logo"];

      public function schema($table){   
        $table = \App\Helpers\Misc::setUpTableFromHeaders($table, $this->headers);
        return $table;
     }
}