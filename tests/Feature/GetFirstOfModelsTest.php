<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetFirstOfModelsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $config = \Config::get('cp');

        try {

            foreach($config['tables'] AS $table){
                $first = $table[0]::first();
                //$this->expectOutputString(true);
                if($first === null){
                    print(PHP_EOL . $table[0] . " returned null ---- (unexpected)");
                }else{
                    print(PHP_EOL . $table[0] . "with id: " . $first->id . " first was gotten (ok)");
                }
                

            } 

            $this->assertTrue(true);
        }

        catch(Throwable $e){
            print PHP_EOL . 'Could not new up a model class.';
            $this->assertTrue(false);
        }
    }
}
