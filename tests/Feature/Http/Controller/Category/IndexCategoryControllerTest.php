<?php

namespace Tests\Feature\Http\Controller\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
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

        $response = $this->withHeader("Content-Type", "application/json")
            ->json("get", route("categories.index"));

        $response->assertStatus(200);
        $response->assertJsonCount(10, "data.*.title");
    }

    public function testAccessIndexWithSearch(){
        $category = Category::factory()->state(["title" => "title for test"])->create();

        Category::factory()->count(10)->create();

        $response = $this->withHeader("Content-Type", "application/json")
            ->json("get", route("categories.index") . "?search=" . $category->title);

        $response->assertStatus(200);
        $response->assertJsonCount(1, "data.*.title");
        $response->assertJson([
            "first_page_url" => route("categories.index") . "?search=".str_replace(" ", "%20", $category->title)."&page=1"
        ]);
    }
}
