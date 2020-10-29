<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewUpModelsTest extends TestCase
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
                new $table[0];
                //$this->expectOutputString(true);
                print(PHP_EOL . $table[0] . " was NEWED UP (ok)");
            } 
            $this->assertTrue(true);
        }

        catch(Throwable $e){
            print PHP_EOL . 'Could not new up a model class.';
            $this->assertTrue(false);
        }
        
    }
}
