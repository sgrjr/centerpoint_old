<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;

class GraphqlSchemaTest extends TestCase
{
    use MakesGraphQLRequests;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testQueriesPosts()
    {
        $title = factory(\App\Inventory::class)->create();

        $this->graphQL(/** @lang GraphQL */ '
        {
            title(id: '.$title->id.') {
                id
                TITLE
            }
        }
        ')->assertJson([
            'data' => [
                'title' =>
                    [
                        'id' => $title->id,
                        'TITLE' => $title->TITLE,
                    ]
                
            ]
        ]);
    }
}
