<?php namespace App\Models;

class WebSocketStatistic extends BaseModel implements \App\Interfaces\ModelInterface
{
  protected $fillable = ['app_id','peak_connection_count','websocket_message_count','api_message_count'];

  protected $attributeTypes = [
    "app_id"=>[
        "name" => "app_id",
        "type" => "VARCHAR",
        "length" => 255
       ],
   "peak_connection_count"=>[
        "name" => "peak_connection_count",
        "type" => "INT",
        "length" => false
       ],
   "websocket_message_count"=>[
        "name" => "websocket_message_count",
        "type" => "INT",
        "length" => false
       ],
   "api_message_count"=>[
        "name" => "api_message_count",
        "type" => "INT",
        "length" => false
       ],
   "created_at"=>[
        "name" => "created_at",
        "type" => "TIMESTAMP",
        "length" => 19
       ],
   "updated_at"=>[
        "name" => "updated_at",
        "type" => "TIMESTAMP",
        "length" => 19
   ],
  ];
          
  protected $table = "websockets_statistics_entries";
  protected $seed = [];

  public function schema($table){
    $table->string('app_id');
    $table->integer('peak_connection_count');
    $table->integer('websocket_message_count');
    $table->integer('api_message_count');
    $table->nullableTimestamps();
    return $table;
   }
}
