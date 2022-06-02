<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/*
assertTrue()
assertFalse()
assertEquals()
assertNull()
assertContains()
assertCount()
assertEmpty()
*/

class InventoryTest extends TestCase
{

    public function CountRecordsDBF()
    {
    	$inventory =  \App\Inventory::dbf()->all()->records;
        $this->assertCount(2475, $inventory);

/*
Time: 3.66 seconds, Memory: 42.00 MB <- from DBF

*/


     
    }

    public function testCountRecords()
    {
        $inventory =  \App\Inventory::mysql()->all()->records;
    

        $this->assertCount(2475, $inventory);

/*
Time: 2.28 to 2.8 seconds, Memory: 64.00 MB <- from DBF
*/
    }

       public function ignoredCountRecords()
    {
        $inventory =  \App\Inventory::ask()->all()->records;
        //$vendor =  \App\Vendor::ask()->all()->records;
        //$webhead =  \App\Webhead::ask()->all()->records;
        //$ancienthead =  \App\Ancienthead::ask()->all()->records;

        $this->assertCount(2475, $inventory);

/*
Time: 3.66 seconds, Memory: 42.00 MB <- from DBF

*/


        //$this->assertCount(14191, $vendor);
        //$this->assertCount(299, $webhead);
        //$this->assertCount(299, $ancienthead);

        //$this->assertEmpty($records);
    }

}
