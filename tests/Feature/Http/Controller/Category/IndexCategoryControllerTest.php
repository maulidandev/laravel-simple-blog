<?php

namespace Tests\Feature\Http\Controller\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAccessIndex()
    {
        $response = $this->get(route("categories.index"));

        $response->assertStatus(200);
    }
}
