<?php

namespace Tests\Feature\Http\Controller\Category;

use App\Models\Category;
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
        Category::factory()->count(10)->create();

        $this->assertDatabaseCount("categories", 10);

        $response = $this->get(route("categories.index"));

        $response->assertStatus(200);
    }
}
