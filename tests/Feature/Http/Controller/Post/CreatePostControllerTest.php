<?php

namespace Tests\Feature\Http\Controller\Post;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePostControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUsingValidData()
    {
        $category = Category::factory()->create();
        $data = [
            "title" => $this->faker->words(3, true),
            "category_id" => $category->id,
            "content" => $this->faker->text
        ];

        $this->assertDatabaseHas("categories", ["id" => $category->id]);
        $this->assertDatabaseCount("posts", 0);

        $response = $this->from(route("posts.create"))
            ->post(route("posts.store"), $data);

        $this->assertDatabaseHas("posts", $data);

        $response->assertStatus(302);
        $response->assertRedirect(route("posts.index"));
    }

    public function testUsingInvalidTitle(){
        $category = Category::factory()->create();

        $this->assertDatabaseHas("categories", ["id" => $category->id]);
        $this->assertDatabaseCount("posts", 0);

        $response = $this->from(route("posts.create"))
            ->post(route("posts.store"), [
                "title" => $this->faker->words(500, true),
                "category_id" => $category->id,
                "content" => $this->faker->text
            ]);

        $this->assertDatabaseCount("posts", 0);

        $response->assertStatus(302);
        $response->assertRedirect(route("posts.create"));
    }

    public function testUsingNotUniqeTitle(){
        $post = Post::factory()->create();
        $this->assertDatabaseHas("posts", ["id" => $post->id]);

        $category = Category::factory()->create();

        $response = $this->from(route("posts.create"))
            ->post(route("posts.store"), [
                "title" => $post->title,
                "category_id" => $category->id,
                "content" => $this->faker->text
            ]);

        $this->assertDatabaseCount("posts", 1);

        $response->assertStatus(302);
        $response->assertRedirect(route("posts.create"));
    }
}
