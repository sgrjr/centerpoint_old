<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Webdetail;
use App\Models\User;

class AddTitleToCartTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $input = [
            "PROD_NO"=>"9781628998887",
            "REMOTEADDR"=> 64042,
            "REQUESTED"=> 1
        ];
        $root = false;
        $attributes = $input;
        $request = false;
        $x = false;
        $user = User::find(1);

        $result = Webdetail::dbfUpdateOrCreate($root, $attributes, $request, $x, $user);

        $checked = $user->vendor->webdetailsOrders->where('REMOTEADDR',$input["REMOTEADDR"])->where("PROD_NO",$input["PROD_NO"])->first();

        $this->assertTrue($checked != null);
    }
}
