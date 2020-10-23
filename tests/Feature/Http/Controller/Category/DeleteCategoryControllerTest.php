<?php

namespace Tests\Feature\Http\Controller\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteCategory()
    {
        $category = Category::factory()->create();

        $this->assertDatabaseHas("categories", [
            "id" => $category->id
        ]);

        $response = $this->from(route("categories.index"))
            ->post(route("categories.destroy", $category->id), [
                "_method" => "delete"
            ]);

        $this->assertDatabaseMissing("categories", [
            "id" => $category->id
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("categories.index"));
    }

    public function testDeleteInvalidID(){
        $category = Category::factory()->create();

        $this->assertDatabaseMissing("categories", [
            "id" => $category->id+1
        ]);

        $response = $this->json("delete", route("categories.destroy", $category->id+1));

        $response->assertStatus(404);
    }
}
