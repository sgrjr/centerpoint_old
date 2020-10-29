<?php

namespace App;

<<<<<<< HEAD
class Request extends BaseModel implements \App\Interfaces\ModelInterface
{
    protected $seed = [];
	protected $appends = [];
	protected $table = "passfiles";
	protected $dbfPrimaryKey = 'INDEX';

    public function schema($table){
     $table->text("request");
     $table->text("response");
     $table->string("url", 1024);
     $table->string("ip", 16);
     $table->timestamps();
    return $table;
   }
=======
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    //
>>>>>>> 90f2f5f0e5a0ebb6079d9f0e74ea1862bfe8b809
}
