<?php

namespace Tests\Feature\Http\Controller\Category;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

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

        $response = $this->from(route("admin.categories.index"))
            ->post(route("admin.categories.destroy", $category->id), [
                "_method" => "delete"
            ]);

        $this->assertDatabaseMissing("categories", [
            "id" => $category->id
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route("admin.categories.index"));
    }

    public function testDeleteInvalidID(){
        $category = Category::factory()->create();

        $this->assertDatabaseMissing("categories", [
            "id" => $category->id+1
        ]);

        $response = $this->json("delete", route("admin.categories.destroy", $category->id+1));

        $response->assertStatus(404);
    }

    public function testDeleteUncategorize(){
        $response = $this->from(route("admin.categories.index"))
            ->delete(route("admin.categories.destroy", 1));

        $response->assertStatus(403);
    }

    public function testDeleteCategoryWithPostRelation(){
        $category = Category::factory()->create();
        $post = Post::factory()->state(["category_id" => $category->id])->create();

        $response = $this->from(route("admin.categories.index"))
            ->delete(route("admin.categories.destroy", $category->id));

        $response->assertStatus(302);
        $this->assertDatabaseHas("posts", [
            "id" => $post->id,
            "category_id" => 1
        ]);
        $response->assertRedirect(route("admin.categories.index"));
    }
}
